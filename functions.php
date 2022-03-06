<?php
    require_once("config.php");


    function company_plan_details($UID) {
        global $CONN;

        $stmnt = "
            SELECT
            company_plan_details.cpland_id,
            COMPANY_PIC_DETAILS.cpicd_id,
            COMPANY_PIC_DETAILS.cid,
            COMPANY_PIC_DETAILS.cname,
            COMPANY_PIC_DETAILS.cemail,
            COMPANY_PIC_DETAILS.caddress,
            COMPANY_PIC_DETAILS.ccontactno,
            COMPANY_PIC_DETAILS.cpic_id,
            COMPANY_PIC_DETAILS.dp_link,
            COMPANY_PIC_DETAILS.cover_link,
            COMPANY_PIC_DETAILS.clast_logind,
            COMPANY_PIC_DETAILS.csign_time,
            plan.pid,
            plan.pname,
            plan.monthly_fee,
            plan.operation_hours,
            plan.num_of_cars
        FROM
            (
                (
                    company_plan_details
                INNER JOIN(
                    SELECT
                        cpicd_id,
                        company.cid,
                        company.cname,
                        company.cemail,
                        company.caddress,
                        company.ccontactno,
                        company.clast_logind,
                        company.csign_time,
                        company_pic.cpic_id,
                        company_pic.dp_link,
                        company_pic.cover_link
                    FROM
                        (
                            (
                                company_pic_details
                            INNER JOIN company ON company_pic_details.cid = company.cid
                            )
                        INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                        )
                ) AS COMPANY_PIC_DETAILS
            ON
                company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                )
            INNER JOIN plan ON company_plan_details.pid = plan.pid
            ) WHERE cid = $UID;
        ";
        
        $query = $CONN->query($stmnt);

        if ($query->num_rows <= 0) {

            return json_encode(Array(
                "statusCode" => 70 ,
                "message" => "no record found!"
            ));

        }
        else {

            $arr = Array(
                "statusCode" => 69,
                "message" => "success!",
                "data" => Array()
            );

            $fields = $query->fetch_fields();
            $row = $query->fetch_assoc();

            
            foreach ($fields as $f) {

                $val = $row[$f->name];

                if (!isset($val) || empty($val) || $val == null ) {
                    $val = "N/A";
                }

                $arr["data"][$f->name] = $val;
            }

            return json_encode($arr);
        }
    }

    function company_car_details($UID,$caridfilter = null) {
        global $CONN;
        $stmnt = "
        SELECT
        ccd_id,
        COMPANY_PLAN_DETAILS.cid,
        car.carid,
        car.brand,
        car.model,
        car.plateno,
        car.rate_per_day
    FROM
        (
            (
                company_car_details
            INNER JOIN(
                SELECT
                    company_plan_details.cpland_id,
                    COMPANY_PIC_DETAILS.cpicd_id,
                    COMPANY_PIC_DETAILS.cid,
                    COMPANY_PIC_DETAILS.cname,
                    COMPANY_PIC_DETAILS.cemail,
                    COMPANY_PIC_DETAILS.caddress,
                    COMPANY_PIC_DETAILS.ccontactno,
                    COMPANY_PIC_DETAILS.cpic_id,
                    COMPANY_PIC_DETAILS.dp_link,
                    COMPANY_PIC_DETAILS.cover_link,
                    plan.pid,
                    plan.pname,
                    plan.monthly_fee,
                    plan.operation_hours
                FROM
                    (
                        (
                            company_plan_details
                        INNER JOIN(
                            SELECT
                                cpicd_id,
                                company.cid,
                                company.cname,
                                company.cemail,
                                company.caddress,
                                company.ccontactno,
                                company_pic.cpic_id,
                                company_pic.dp_link,
                                company_pic.cover_link
                            FROM
                                (
                                    (
                                        company_pic_details
                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                    )
                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                )
                        ) AS COMPANY_PIC_DETAILS
                    ON
                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                        )
                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                    )
            ) AS COMPANY_PLAN_DETAILS
        ON
            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
            )
        INNER JOIN car ON company_car_details.carid = car.carid
        )
    WHERE
        (
            ccd_id NOT IN(
            SELECT
                booking.ccd_id
            FROM
                (
                    (
                        (
                            booking
                        INNER JOIN renter ON booking.rid = renter.rid
                        )
                    INNER JOIN(
                        SELECT
                            ccd_id,
                            COMPANY_PLAN_DETAILS.cid,
                            car.carid,
                            car.brand,
                            car.model,
                            car.plateno,
                            car.rate_per_day
                        FROM
                            (
                                (
                                    company_car_details
                                INNER JOIN(
                                    SELECT
                                        company_plan_details.cpland_id,
                                        COMPANY_PIC_DETAILS.cpicd_id,
                                        COMPANY_PIC_DETAILS.cid,
                                        COMPANY_PIC_DETAILS.cname,
                                        COMPANY_PIC_DETAILS.cemail,
                                        COMPANY_PIC_DETAILS.caddress,
                                        COMPANY_PIC_DETAILS.ccontactno,
                                        COMPANY_PIC_DETAILS.cpic_id,
                                        COMPANY_PIC_DETAILS.dp_link,
                                        COMPANY_PIC_DETAILS.cover_link,
                                        plan.pid,
                                        plan.pname,
                                        plan.monthly_fee,
                                        plan.operation_hours
                                    FROM
                                        (
                                            (
                                                company_plan_details
                                            INNER JOIN(
                                                SELECT
                                                    cpicd_id,
                                                    company.cid,
                                                    company.cname,
                                                    company.cemail,
                                                    company.caddress,
                                                    company.ccontactno,
                                                    company_pic.cpic_id,
                                                    company_pic.dp_link,
                                                    company_pic.cover_link
                                                FROM
                                                    (
                                                        (
                                                            company_pic_details
                                                        INNER JOIN company ON company_pic_details.cid = company.cid
                                                        )
                                                    INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                    )
                                            ) AS COMPANY_PIC_DETAILS
                                        ON
                                            company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                            )
                                        INNER JOIN plan ON company_plan_details.pid = plan.pid
                                        )
                                ) AS COMPANY_PLAN_DETAILS
                            ON
                                company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                                )
                            INNER JOIN car ON company_car_details.carid = car.carid
                            )
                    ) AS COMPANY_CAR_DETAILS
                ON
                    booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                    )
                INNER JOIN booking_status ON booking.bsid = booking_status.bsid
                )
            WHERE
                cid = $UID AND booking.bsid IN(1, 2, 5)
        )
        ) AND cid = $UID 
        ";

        if ($caridfilter != null) {
            $stmnt .= " AND car.carid = $caridfilter;";
        }
        else {
            $stmnt .= ";";
        }
        
        $query = $CONN->query($stmnt);
        $car_array = Array();
        if ($query->num_rows > 0) {

            while ($row = $query->fetch_assoc()) {
                $car   = Array();
                $carid = $row["carid"];
                $keys  = array_keys($row);
                foreach($keys as $k) {
                    $car[$k] = $row[$k];
                }

                $imgstmnt = "SELECT * FROM car_images WHERE carid = $carid;";
                $imgquery = $CONN->query($imgstmnt);
                if ($imgquery->num_rows > 0) {
                    $images = Array();
                    while ($row1  = $imgquery->fetch_assoc()) {
                        array_push(
                            $images,
                            Array(
                                "carimg_id"  => $row1["carimg_id"],
                                "image_link" => $row1["image_link"]
                            )
                        );
                    }
                    $car["images"] = $images;
                }
                array_push($car_array,$car);
            }

        }
      
        return $car_array;
    }

    function getAllCars($UID) {
        global $CONN;
        $stmnt = "
        SELECT
        ccd_id,
        COMPANY_PLAN_DETAILS.cid,
        car.carid,
        car.brand,
        car.model,
        car.plateno,
        car.rate_per_day
    FROM
        (
            (
                company_car_details
            INNER JOIN(
                SELECT
                    company_plan_details.cpland_id,
                    COMPANY_PIC_DETAILS.cpicd_id,
                    COMPANY_PIC_DETAILS.cid,
                    COMPANY_PIC_DETAILS.cname,
                    COMPANY_PIC_DETAILS.cemail,
                    COMPANY_PIC_DETAILS.caddress,
                    COMPANY_PIC_DETAILS.ccontactno,
                    COMPANY_PIC_DETAILS.cpic_id,
                    COMPANY_PIC_DETAILS.dp_link,
                    COMPANY_PIC_DETAILS.cover_link,
                    plan.pid,
                    plan.pname,
                    plan.monthly_fee,
                    plan.operation_hours
                FROM
                    (
                        (
                            company_plan_details
                        INNER JOIN(
                            SELECT
                                cpicd_id,
                                company.cid,
                                company.cname,
                                company.cemail,
                                company.caddress,
                                company.ccontactno,
                                company_pic.cpic_id,
                                company_pic.dp_link,
                                company_pic.cover_link
                            FROM
                                (
                                    (
                                        company_pic_details
                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                    )
                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                )
                        ) AS COMPANY_PIC_DETAILS
                    ON
                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                        )
                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                    )
            ) AS COMPANY_PLAN_DETAILS
        ON
            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
            )
        INNER JOIN car ON company_car_details.carid = car.carid
        ) WHERE cid = $UID 
        ";

        $query = $CONN->query($stmnt);
        $car_array = Array();
        if ($query->num_rows > 0) {

            while ($row = $query->fetch_assoc()) {
                $car   = Array();
                $carid = $row["carid"];
                $keys  = array_keys($row);
                foreach($keys as $k) {
                    $car[$k] = $row[$k];
                }

                $imgstmnt = "SELECT * FROM car_images WHERE carid = $carid;";
                $imgquery = $CONN->query($imgstmnt);
                if ($imgquery->num_rows > 0) {
                    $images = Array();
                    while ($row1  = $imgquery->fetch_assoc()) {
                        array_push(
                            $images,
                            Array(
                                "carimg_id"  => $row1["carimg_id"],
                                "image_link" => $row1["image_link"]
                            )
                        );
                    }
                    $car["images"] = $images;
                }
                array_push($car_array,$car);
            }

        }
       
        return $car_array;
    }

    function booking($UID,$bsidfilter = null) {
        global $CONN;

        $stmnt = "
            SELECT
            *
        FROM
            (
                (
                    (
                        booking
                    INNER JOIN renter ON booking.rid = renter.rid
                    )
                INNER JOIN(
                    SELECT
                        ccd_id,
                        COMPANY_PLAN_DETAILS.cid,
                        car.carid,
                        car.brand,
                        car.model,
                        car.plateno,
                        car.rate_per_day
                    FROM
                        (
                            (
                                company_car_details
                            INNER JOIN(
                                SELECT
                                    company_plan_details.cpland_id,
                                    COMPANY_PIC_DETAILS.cpicd_id,
                                    COMPANY_PIC_DETAILS.cid,
                                    COMPANY_PIC_DETAILS.cname,
                                    COMPANY_PIC_DETAILS.cemail,
                                    COMPANY_PIC_DETAILS.caddress,
                                    COMPANY_PIC_DETAILS.ccontactno,
                                    COMPANY_PIC_DETAILS.cpic_id,
                                    COMPANY_PIC_DETAILS.dp_link,
                                    COMPANY_PIC_DETAILS.cover_link,
                                    plan.pid,
                                    plan.pname,
                                    plan.monthly_fee,
                                    plan.operation_hours
                                FROM
                                    (
                                        (
                                            company_plan_details
                                        INNER JOIN(
                                            SELECT
                                                cpicd_id,
                                                company.cid,
                                                company.cname,
                                                company.cemail,
                                                company.caddress,
                                                company.ccontactno,
                                                company_pic.cpic_id,
                                                company_pic.dp_link,
                                                company_pic.cover_link
                                            FROM
                                                (
                                                    (
                                                        company_pic_details
                                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                                    )
                                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                )
                                        ) AS COMPANY_PIC_DETAILS
                                    ON
                                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                        )
                                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                                    )
                            ) AS COMPANY_PLAN_DETAILS
                        ON
                            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                            )
                        INNER JOIN car ON company_car_details.carid = car.carid
                        )
                ) AS COMPANY_CAR_DETAILS
            ON
                booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                )
            INNER JOIN booking_status ON booking.bsid = booking_status.bsid
            ) WHERE cid = $UID 
        ";

        if ($bsidfilter != null) {
            $stmnt .= " AND booking_status.bsid = $bsidfilter ORDER BY bid DESC;";
        }
        else {
            $stmnt .= " ORDER BY bid DESC;";
        }

        $query = $CONN->query($stmnt);
      

        $booking = Array();

        if ($query->num_rows > 0) {
            
            while ($row = $query->fetch_assoc()) {
                $map  = Array(); 
                $keys = array_keys($row);
                foreach($keys as $k) {
                    $map[$k] = $row[$k];
                }
                array_push($booking,$map);
            }

        }

        return $booking;
    }

    function getBooking($UID,$bid) {
        global $CONN;

        $stmnt = "
            SELECT
            *
        FROM
            (
                (
                    (
                        booking
                    INNER JOIN renter ON booking.rid = renter.rid
                    )
                INNER JOIN(
                    SELECT
                        ccd_id,
                        COMPANY_PLAN_DETAILS.cid,
                        car.carid,
                        car.brand,
                        car.model,
                        car.plateno,
                        car.rate_per_day
                    FROM
                        (
                            (
                                company_car_details
                            INNER JOIN(
                                SELECT
                                    company_plan_details.cpland_id,
                                    COMPANY_PIC_DETAILS.cpicd_id,
                                    COMPANY_PIC_DETAILS.cid,
                                    COMPANY_PIC_DETAILS.cname,
                                    COMPANY_PIC_DETAILS.cemail,
                                    COMPANY_PIC_DETAILS.caddress,
                                    COMPANY_PIC_DETAILS.ccontactno,
                                    COMPANY_PIC_DETAILS.cpic_id,
                                    COMPANY_PIC_DETAILS.dp_link,
                                    COMPANY_PIC_DETAILS.cover_link,
                                    plan.pid,
                                    plan.pname,
                                    plan.monthly_fee,
                                    plan.operation_hours
                                FROM
                                    (
                                        (
                                            company_plan_details
                                        INNER JOIN(
                                            SELECT
                                                cpicd_id,
                                                company.cid,
                                                company.cname,
                                                company.cemail,
                                                company.caddress,
                                                company.ccontactno,
                                                company_pic.cpic_id,
                                                company_pic.dp_link,
                                                company_pic.cover_link
                                            FROM
                                                (
                                                    (
                                                        company_pic_details
                                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                                    )
                                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                )
                                        ) AS COMPANY_PIC_DETAILS
                                    ON
                                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                        )
                                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                                    )
                            ) AS COMPANY_PLAN_DETAILS
                        ON
                            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                            )
                        INNER JOIN car ON company_car_details.carid = car.carid
                        )
                ) AS COMPANY_CAR_DETAILS
            ON
                booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                )
            INNER JOIN booking_status ON booking.bsid = booking_status.bsid
            ) WHERE cid = $UID AND bid = $bid;
        ";
        $book = $CONN->query($stmnt);
        if ($book->num_rows <= 0) {
            echo json_encode(Array(
                "statusCode" => 70,
                "message" => "empty result!"
            ));
        }
        else {
            $array = Array();

            $row = $book->fetch_assoc();

            $keys = array_keys($row);
            foreach($keys as $k) {
                $array[$k] = $row[$k];
            }

            $cid = $row["carid"];
            $imgsquer = "SELECT image_link FROM car_images WHERE carid = $cid;";

            $images = Array();

            $imgres = $CONN->query($imgsquer); 

            if ($imgres->num_rows <= 0) {
                json_encode(Array(
                    "statusCode" => 70,
                    "message" => "empty result!"
                ));
            }
            else {
                
                while ($imgrow = $imgres->fetch_assoc()) {
                    array_push($images,$imgrow["image_link"]);
                }
                $array["images"] = $images;
                echo json_encode(Array(
                    "statusCode" => 69,
                    "message" => "success!",
                    "data" => $array
                ));
            }
        }

    }

    function countNewBooking($UID) {
        global $CONN;
        $stmnt = "
            SELECT
            count(*) AS new_booking
        FROM
            (
                (
                    (
                        booking
                    INNER JOIN renter ON booking.rid = renter.rid
                    )
                INNER JOIN(
                    SELECT
                        ccd_id,
                        COMPANY_PLAN_DETAILS.cid,
                        car.carid,
                        car.brand,
                        car.model,
                        car.plateno,
                        car.rate_per_day
                    FROM
                        (
                            (
                                company_car_details
                            INNER JOIN(
                                SELECT
                                    company_plan_details.cpland_id,
                                    COMPANY_PIC_DETAILS.cpicd_id,
                                    COMPANY_PIC_DETAILS.cid,
                                    COMPANY_PIC_DETAILS.cname,
                                    COMPANY_PIC_DETAILS.cemail,
                                    COMPANY_PIC_DETAILS.caddress,
                                    COMPANY_PIC_DETAILS.ccontactno,
                                    COMPANY_PIC_DETAILS.cpic_id,
                                    COMPANY_PIC_DETAILS.dp_link,
                                    COMPANY_PIC_DETAILS.cover_link,
                                    plan.pid,
                                    plan.pname,
                                    plan.monthly_fee,
                                    plan.operation_hours
                                FROM
                                    (
                                        (
                                            company_plan_details
                                        INNER JOIN(
                                            SELECT
                                                cpicd_id,
                                                company.cid,
                                                company.cname,
                                                company.cemail,
                                                company.caddress,
                                                company.ccontactno,
                                                company_pic.cpic_id,
                                                company_pic.dp_link,
                                                company_pic.cover_link
                                            FROM
                                                (
                                                    (
                                                        company_pic_details
                                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                                    )
                                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                )
                                        ) AS COMPANY_PIC_DETAILS
                                    ON
                                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                        )
                                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                                    )
                            ) AS COMPANY_PLAN_DETAILS
                        ON
                            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                            )
                        INNER JOIN car ON company_car_details.carid = car.carid
                        )
                ) AS COMPANY_CAR_DETAILS
            ON
                booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                )
            INNER JOIN booking_status ON booking.bsid = booking_status.bsid
            ) WHERE booking.bsid = 1 AND cid = $UID;
        ";

        $query = $CONN->query($stmnt);
      

        if ($query->num_rows <= 0) {
            return Array(
                "statusCode" => 70 , 
                "message" => "No data!"
            );
        }
        else {
            $row = $query->fetch_assoc();
            return Array(
                "statusCode" => 69 , 
                "message" => "success!",
                "data" => $row["new_booking"]
            );
        }
    }

    function countBookDate($UID,$column,$date) {
        global $CONN;
        $stmnt = "
            SELECT
            count(*) AS event_date
        FROM
            (
                (
                    (
                        booking
                    INNER JOIN renter ON booking.rid = renter.rid
                    )
                INNER JOIN(
                    SELECT
                        ccd_id,
                        COMPANY_PLAN_DETAILS.cid,
                        car.carid,
                        car.brand,
                        car.model,
                        car.plateno,
                        car.rate_per_day
                    FROM
                        (
                            (
                                company_car_details
                            INNER JOIN(
                                SELECT
                                    company_plan_details.cpland_id,
                                    COMPANY_PIC_DETAILS.cpicd_id,
                                    COMPANY_PIC_DETAILS.cid,
                                    COMPANY_PIC_DETAILS.cname,
                                    COMPANY_PIC_DETAILS.cemail,
                                    COMPANY_PIC_DETAILS.caddress,
                                    COMPANY_PIC_DETAILS.ccontactno,
                                    COMPANY_PIC_DETAILS.cpic_id,
                                    COMPANY_PIC_DETAILS.dp_link,
                                    COMPANY_PIC_DETAILS.cover_link,
                                    plan.pid,
                                    plan.pname,
                                    plan.monthly_fee,
                                    plan.operation_hours
                                FROM
                                    (
                                        (
                                            company_plan_details
                                        INNER JOIN(
                                            SELECT
                                                cpicd_id,
                                                company.cid,
                                                company.cname,
                                                company.cemail,
                                                company.caddress,
                                                company.ccontactno,
                                                company_pic.cpic_id,
                                                company_pic.dp_link,
                                                company_pic.cover_link
                                            FROM
                                                (
                                                    (
                                                        company_pic_details
                                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                                    )
                                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                )
                                        ) AS COMPANY_PIC_DETAILS
                                    ON
                                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                        )
                                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                                    )
                            ) AS COMPANY_PLAN_DETAILS
                        ON
                            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                            )
                        INNER JOIN car ON company_car_details.carid = car.carid
                        )
                ) AS COMPANY_CAR_DETAILS
            ON
                booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                )
            INNER JOIN booking_status ON booking.bsid = booking_status.bsid
            ) WHERE cid = $UID 
        ";

        if (strcmp($column,"pickup_date") == 0) {
            $stmnt .= "AND (booking.$column = '$date' AND booking.bsid = 2) ;";
        }
        else if (strcmp($column,"return_date") == 0) {
            $stmnt .= "AND (booking.$column = '$date' AND booking.bsid = 5) ;";
        }
        else {
            $stmnt .= ";";
        }

        $query = $CONN->query($stmnt);
       

        if ($query->num_rows <= 0) {
            return Array(
                "statusCode" => 70 , 
                "message" => "No data!"
            );
        }
        else {
            $row = $query->fetch_assoc();
            return Array(
                "statusCode" => 69 , 
                "message" => "success!",
                "data" => $row["event_date"]
            );
        }
    }

    function countAlarm($UID,$datenow) {
        global $CONN;

        $stmnt = "
            SELECT
            return_date
        FROM
            (
                (
                    (
                        booking
                    INNER JOIN renter ON booking.rid = renter.rid
                    )
                INNER JOIN(
                    SELECT
                        ccd_id,
                        COMPANY_PLAN_DETAILS.cid,
                        car.carid,
                        car.brand,
                        car.model,
                        car.plateno,
                        car.rate_per_day
                    FROM
                        (
                            (
                                company_car_details
                            INNER JOIN(
                                SELECT
                                    company_plan_details.cpland_id,
                                    COMPANY_PIC_DETAILS.cpicd_id,
                                    COMPANY_PIC_DETAILS.cid,
                                    COMPANY_PIC_DETAILS.cname,
                                    COMPANY_PIC_DETAILS.cemail,
                                    COMPANY_PIC_DETAILS.caddress,
                                    COMPANY_PIC_DETAILS.ccontactno,
                                    COMPANY_PIC_DETAILS.cpic_id,
                                    COMPANY_PIC_DETAILS.dp_link,
                                    COMPANY_PIC_DETAILS.cover_link,
                                    plan.pid,
                                    plan.pname,
                                    plan.monthly_fee,
                                    plan.operation_hours
                                FROM
                                    (
                                        (
                                            company_plan_details
                                        INNER JOIN(
                                            SELECT
                                                cpicd_id,
                                                company.cid,
                                                company.cname,
                                                company.cemail,
                                                company.caddress,
                                                company.ccontactno,
                                                company_pic.cpic_id,
                                                company_pic.dp_link,
                                                company_pic.cover_link
                                            FROM
                                                (
                                                    (
                                                        company_pic_details
                                                    INNER JOIN company ON company_pic_details.cid = company.cid
                                                    )
                                                INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                )
                                        ) AS COMPANY_PIC_DETAILS
                                    ON
                                        company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                        )
                                    INNER JOIN plan ON company_plan_details.pid = plan.pid
                                    )
                            ) AS COMPANY_PLAN_DETAILS
                        ON
                            company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                            )
                        INNER JOIN car ON company_car_details.carid = car.carid
                        )
                ) AS COMPANY_CAR_DETAILS
            ON
                booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                )
            INNER JOIN booking_status ON booking.bsid = booking_status.bsid
            ) WHERE cid = $UID AND booking.bsid = 5;
        ";

        $query = $CONN->query($stmnt);
      

        if ($query->num_rows <= 0) {
            return Array(
                "statusCode" => 70 , 
                "message" => "No data!"
            );
        }
        else {

            $count = 0;
            while ($row = $query->fetch_assoc()) {
                $date = $row["return_date"];
                $d1 = strtotime($date);
                $d2 = strtotime($datenow);

                if ($d1 < $d2) 
                    $count++;
                
               
            }
            return Array(
                "statusCode" => 69 , 
                "message" => "success!",
                "data" => $count
            );
        }
    }

    function carStatus($UID) {
        $count = count(company_car_details($UID));
        return Array(
            "statusCode" => 69 , 
            "message" => "success!",
            "data" => Array(
                "available" => $count,
                "unavailable" => count(getAllCars($UID)) - $count
            )
        );
    }

    function getMonthlyProfit($UID,$prevCount,$date) {
        global $CONN;

        $stmnt = "
            SELECT
            DATE_FORMAT(tend, '%Y-%M') AS yyyy_mm,
            SUM(tammount) AS profit
        FROM
            (
                (
                    transaction
                INNER JOIN(
                    SELECT
                        bid,
                        cid,
                        pickup_date
                    FROM
                        (
                            (
                                (
                                    booking
                                INNER JOIN renter ON booking.rid = renter.rid
                                )
                            INNER JOIN(
                                SELECT
                                    ccd_id,
                                    COMPANY_PLAN_DETAILS.cid,
                                    car.carid,
                                    car.brand,
                                    car.model,
                                    car.plateno,
                                    car.rate_per_day
                                FROM
                                    (
                                        (
                                            company_car_details
                                        INNER JOIN(
                                            SELECT
                                                company_plan_details.cpland_id,
                                                COMPANY_PIC_DETAILS.cpicd_id,
                                                COMPANY_PIC_DETAILS.cid,
                                                COMPANY_PIC_DETAILS.cname,
                                                COMPANY_PIC_DETAILS.cemail,
                                                COMPANY_PIC_DETAILS.caddress,
                                                COMPANY_PIC_DETAILS.ccontactno,
                                                COMPANY_PIC_DETAILS.cpic_id,
                                                COMPANY_PIC_DETAILS.dp_link,
                                                COMPANY_PIC_DETAILS.cover_link,
                                                plan.pid,
                                                plan.pname,
                                                plan.monthly_fee,
                                                plan.operation_hours
                                            FROM
                                                (
                                                    (
                                                        company_plan_details
                                                    INNER JOIN(
                                                        SELECT
                                                            cpicd_id,
                                                            company.cid,
                                                            company.cname,
                                                            company.cemail,
                                                            company.caddress,
                                                            company.ccontactno,
                                                            company_pic.cpic_id,
                                                            company_pic.dp_link,
                                                            company_pic.cover_link
                                                        FROM
                                                            (
                                                                (
                                                                    company_pic_details
                                                                INNER JOIN company ON company_pic_details.cid = company.cid
                                                                )
                                                            INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                            )
                                                    ) AS COMPANY_PIC_DETAILS
                                                ON
                                                    company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                                    )
                                                INNER JOIN plan ON company_plan_details.pid = plan.pid
                                                )
                                        ) AS COMPANY_PLAN_DETAILS
                                    ON
                                        company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                                        )
                                    INNER JOIN car ON company_car_details.carid = car.carid
                                    )
                            ) AS COMPANY_CAR_DETAILS
                        ON
                            booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                            )
                        INNER JOIN booking_status ON booking.bsid = booking_status.bsid
                        )
                    WHERE
                        cid = $UID
                ) AS BOOKING
            ON transaction
                .bid = BOOKING.bid
                )
            INNER JOIN transaction_status ON transaction
                .tsid = transaction_status.tsid
            )
        WHERE
            cid = $UID AND (
                tend >=(
                    '$date' - INTERVAL(31 * $prevCount) DAY
                ) AND tend <= '$date'
            )
        GROUP BY
            yyyy_mm ORDER BY yyyy_mm DESC;
        ";

        $query = $CONN->query($stmnt);
       

        if ($query->num_rows <= 0) {
            return Array(
                "statusCode" => 70 , 
                "message" => "No data!"
            );
        }
        else {
            $diff = $prevCount - ($query->num_rows);
            $map = Array();
            while ($row = $query->fetch_assoc()) {
                $date = date_create($row["yyyy_mm"]);
                $mm   = $date->format("m");
                $map[(int)$mm - 1] = $row["profit"];
            }
    
            if ($diff != 0) {
                $first = array_keys($map)[count($map)-1];
                $start = ($first <= 0)?12:$first;
                
                for($idx = 0;$idx < $diff;$idx++)
                    $map[(--$start)] = 0;
                

                ksort($map);
            }
            return Array(
                "statusCode" => 69 , 
                "message" => "success!",
                "data" => $map
            );
        }
    }

    function getOngoingTransactions($UID) {
        global $CONN;
        $stmnt = "
            SELECT
            *
        FROM
            (
                (
                    transaction
                INNER JOIN(
                    SELECT
                        bid,
                        cid,
                        carid,
                        cname,
                        rlname,
                        rmname,
                        rfname,
                        brand,
                        model,
                        plateno
                    FROM
                        (
                            (
                                (
                                    booking
                                INNER JOIN renter ON booking.rid = renter.rid
                                )
                            INNER JOIN(
                                SELECT
                                    ccd_id,
                                    COMPANY_PLAN_DETAILS.cid,
                                    COMPANY_PLAN_DETAILS.cname,
                                    car.carid,
                                    car.brand,
                                    car.model,
                                    car.plateno,
                                    car.rate_per_day
                                FROM
                                    (
                                        (
                                            company_car_details
                                        INNER JOIN(
                                            SELECT
                                                company_plan_details.cpland_id,
                                                COMPANY_PIC_DETAILS.cpicd_id,
                                                COMPANY_PIC_DETAILS.cid,
                                                COMPANY_PIC_DETAILS.cname,
                                                COMPANY_PIC_DETAILS.cemail,
                                                COMPANY_PIC_DETAILS.caddress,
                                                COMPANY_PIC_DETAILS.ccontactno,
                                                COMPANY_PIC_DETAILS.cpic_id,
                                                COMPANY_PIC_DETAILS.dp_link,
                                                COMPANY_PIC_DETAILS.cover_link,
                                                plan.pid,
                                                plan.pname,
                                                plan.monthly_fee,
                                                plan.operation_hours
                                            FROM
                                                (
                                                    (
                                                        company_plan_details
                                                    INNER JOIN(
                                                        SELECT
                                                            cpicd_id,
                                                            company.cid,
                                                            company.cname,
                                                            company.cemail,
                                                            company.caddress,
                                                            company.ccontactno,
                                                            company_pic.cpic_id,
                                                            company_pic.dp_link,
                                                            company_pic.cover_link
                                                        FROM
                                                            (
                                                                (
                                                                    company_pic_details
                                                                INNER JOIN company ON company_pic_details.cid = company.cid
                                                                )
                                                            INNER JOIN company_pic ON company_pic_details.cpic_id = company_pic.cpic_id
                                                            )
                                                    ) AS COMPANY_PIC_DETAILS
                                                ON
                                                    company_plan_details.cpicd_id = COMPANY_PIC_DETAILS.cpicd_id
                                                    )
                                                INNER JOIN plan ON company_plan_details.pid = plan.pid
                                                )
                                        ) AS COMPANY_PLAN_DETAILS
                                    ON
                                        company_car_details.cpland_id = COMPANY_PLAN_DETAILS.cpland_id
                                        )
                                    INNER JOIN car ON company_car_details.carid = car.carid
                                    )
                            ) AS COMPANY_CAR_DETAILS
                        ON
                            booking.ccd_id = COMPANY_CAR_DETAILS.ccd_id
                            )
                        INNER JOIN booking_status ON booking.bsid = booking_status.bsid
                        )
                    WHERE
                        cid = $UID
                ) AS BOOKING
            ON transaction
                .bid = BOOKING.bid
                )
            INNER JOIN transaction_status ON transaction
                .tsid = transaction_status.tsid
            )
        WHERE transaction
            .tsid = 1 AND cid = $UID
        ORDER BY
            tid
        DESC;
        ";

        $query = $CONN->query($stmnt);

        $array = Array();
        
        if ($query->num_rows > 0) {
            while ($row = $query->fetch_assoc()) {
                $tdata = Array();
                $keys  = array_keys($row);
                foreach($keys as $k) {
                    $tdata[$k] = $row[$k];
                }
                array_push($array,$tdata);
            }
        }
        return $array;
    }

?>