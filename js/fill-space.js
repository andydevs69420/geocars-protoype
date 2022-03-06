const fillSpace = (list_id,columnCount) => {
    let list = $(list_id);

    if (list.children().length <= 1)
        return;

    let colCellMax = [];

    for (let _ = 0; _ < columnCount;_++)
        colCellMax.push(0);

    list.children().each((idx0,row) => {

        if ($(row).children().length > colCellMax.length)
            throw "Table not matched!";

        $(row).children().each((idx1,column) => {
            
            let data = $(column).children()[0].innerText;
            
            if (data.length > colCellMax[idx1])
                colCellMax[idx1] = data.length;

        });

    });

    list.children().each((idx0,row) => {

        $(row).children().each((idx1,column) => {
            
            let data = $(column).children()[0].innerText;
            
            if (data.length < colCellMax[idx1]) {

                let diff = (colCellMax[idx1] - data.length) ;
               
                for (let count = 0;count < diff;count++) {
                    data += "&nbsp;";
                    
                    if (count < (diff-1)) 
                        data += "";
                }

                $($(column).children()[0]).html(data);

            }
        
        });

    });

};