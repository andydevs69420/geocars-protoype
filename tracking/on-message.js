
import {sendMessage} from "./connection.js";

export const on_message = (compname,docstringid) => {

    let view = $(`
        <div class="message-overlay">
            <span class="message-panel">
                <button id="close-btn" class="close-btn fa fa-close"></button>
                <textarea id="msg" class="message-content" placeholder="message"></textarea>
                <span class="message-send-row">
                    <button id="send-msg" class="btn-send">
                        <i class="fa fa-paper-plane"></i>
                        <span role="text">Send</span>
                    </button>
                </span>
            </span>
        </div>
    `);

    $("body").prepend(view);
    
    $("#close-btn").click((e) => view.remove());

    $("#send-msg").click((e) => {

        let txt = $("#msg").val();

        if (txt.length <= 0) {
            view.remove();
        }
        else {
            sendMessage(docstringid,{ owner: compname , body: txt });
            view.remove();
        }        
    });

};



