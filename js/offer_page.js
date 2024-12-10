// VARIABLES
// IS CLIENT A PARTICIPANT?
const client_participant = document.querySelectorAll('input[type=radio][name=client_participant]');
const cp_yes_label = document.querySelector('label[for=client_participant_yes]');
const cp_no_label = document.querySelector('label[for=client_participant_no]');

// OTHER PARTICIPANTS
const offer_booking_ui_r_other_participants = document.querySelector('.offer_booking_ui_r_other_participants');
// OTHER PARTICIPANTS ALL INPUTS
var allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
var checkDone = "init";
var numberOfParticipantsConcerned;
// OTHER PARTICIPANTS COUNTER COUNTER
const participants_minus = document.querySelector('button.ob_cp_minus');
const participants_plus = document.querySelector('button.ob_cp_plus');
const participants_number = document.querySelector('input[name=offer_booking_other_participants_number]');
var pn_init = "0";
const opq_num = document.querySelector('.opq_num');

// HEADING OTHER PARTICIPANTS DATA
var participants_other_heading_data = document.querySelector('.other_participatns_data_row');

// ARROWS
const arrow_left = document.querySelector('.offer_booking_ui_arrow__left');
const arrow_right = document.querySelector('.offer_booking_ui_arrow__right');

// STEPS
const first_step = document.querySelector('.offer_booking_ui_r_you');
const second_step = document.querySelector('.offer_booking_ui_r_other_participants');
const third_step = document.querySelector('.offer_booking_ui_r_finalize');
var steps_array = [first_step, second_step, third_step];
var step_displaying = "offer_booking_ui_r_you";

// SUMMARY
const participants_number_summary = document.querySelector('.opb_sum_hmop_answer');
const total_summary = document.querySelector('.opb_sum_total_answer');
const general_price = document.querySelector('h2.offer_page_cost');

// PAYMENTS
const place_to_show_checked = document.querySelectorAll('.offer_booking_payment_right');
const radio_payments = document.querySelectorAll('input[type="radio"][name="offer_booking_payment_method"]');

// FUNCTIONS
function insertAfter(newNode, existingNode) {
    existingNode.parentNode.insertBefore(newNode, existingNode.nextSibling);
}

function addElement (nr, cDiv) {
    const newHeading = document.createElement("div");
    newHeading.classList.add("flexbox");
    newHeading.classList.add("op_dr_p_any");
    newHeading.classList.add("op_dr_p"+nr);
    newHeading.innerHTML = "<h3>Participant " + nr + "</h3><h4>Personal data</h4><div class=\"flexbox op_dr_any_inside_row\"><div class=\"flexbox op_dr_any_input_label_group\"><label for=\"op_dr_p"+nr+"_first_name\">First name:</label><input type=\"text\" name=\"op_dr_p"+nr+"_first_name\" id=\"op_dr_p"+nr+"_first_name\"></div><div class=\"flexbox op_dr_any_input_label_group\"><label for=\"op_dr_p"+nr+"_last_name\">Last name:</label><input type=\"text\" name=\"op_dr_p"+nr+"_last_name\" id=\"op_dr_p"+nr+"_last_name\"></div></div><div class=\"flexbox op_dr_any_input_label_group\"><label for=\"op_dr_p"+nr+"_DOB\">Date of birth:</label><input type=\"date\" name=\"op_dr_p"+nr+"_DOB\" id=\"op_dr_p"+nr+"_DOB\"></div></div><h4>Contact information</h4><div class=\"flexbox op_dr_any_inside_row\"><div class=\"flexbox op_dr_any_input_label_group\"><label for=\"op_dr_p"+nr+"_phone\">Phone:</label><input type=\"text\" name=\"op_dr_p"+nr+"_phone\" id=\"op_dr_p"+nr+"_phone\"></div><div class=\"flexbox op_dr_any_input_label_group\"><label for=\"op_dr_p"+nr+"_email\">E-mail:</label><input type=\"mail\" name=\"op_dr_p"+nr+"_email\" id=\"op_dr_p"+nr+"_email\"></div></div>";
    const currentDiv = document.querySelector(cDiv);
    insertAfter(newHeading, currentDiv);
}

function removeElement (nr) {
    var to_delete = document.querySelector('.op_dr_p' + nr);
    offer_booking_ui_r_other_participants.removeChild(to_delete);
}

// SET CLIENT IS A PARTICPANT TO NO ON LOAD
// ARROW CLICK
window.addEventListener('load', () => {
    client_participant[0].checked = true;
    cp_yes_label.setAttribute("style", "font-weight: 700;");
    arrow_left.setAttribute("style", "display: none;")
});

// ARROW CLICKS
[arrow_left,arrow_right].forEach(arrow_item => {
    arrow_item.addEventListener('click', () => {
        for(var i = 0; i<(steps_array.length); i++) {
            if(steps_array[i].getAttribute("style") === "display: block;") {
                var step_displaying_found = steps_array[i].classList[0];
                var which_arrow = arrow_item.classList[((arrow_item.classList.length)-1)];

                if((step_displaying_found === first_step.classList[0]) && (which_arrow == arrow_right.classList[((arrow_right.classList.length)-1)])) {
                    first_step.setAttribute("style", "display: none;");
                    second_step.setAttribute("style", "display: block;");
                    arrow_left.setAttribute("style", "display: flex;");
                }
                
                if ((step_displaying_found === second_step.classList[0]) && (which_arrow == arrow_left.classList[((arrow_left.classList.length)-1)])) {
                    first_step.setAttribute("style", "display: block;");
                    second_step.setAttribute("style", "display: none;");
                    arrow_left.setAttribute("style", "display: none;");
                }

                if ((step_displaying_found === second_step.classList[0]) && (which_arrow == arrow_right.classList[((arrow_right.classList.length)-1)])) {
                    second_step.setAttribute("style", "display: none;");
                    third_step.setAttribute("style", "display: block;");
                    arrow_right.setAttribute("style", "display: none;");
                    participants_number_summary.textContent = participants_number.value;
                    if(client_participant[0].checked == true) {
                    total_summary.textContent = (
                        (general_price.textContent.substring(1)) + (participants_number.value * (general_price.textContent.substring(1)))
                        );
                    } else if(client_participant[1].checked == true) {
                        total_summary.textContent = (
                        (participants_number.value * (general_price.textContent.substring(1)))
                        );
                    } 
                }

                if ((step_displaying_found === third_step.classList[0]) && (which_arrow == arrow_left.classList[((arrow_left.classList.length)-1)])) {
                    third_step.setAttribute("style", "display: none;");
                    second_step.setAttribute("style", "display: block;");
                    arrow_right.setAttribute("style", "display: flex;");
                }

                break;
            }
        }
    })
});

// ON CHANGE OF RADIO INPUT
client_participant.forEach(item => {
    item.addEventListener('change', () => {
        if(item.classList[0] === "cp_yes") {
            cp_yes_label.setAttribute("style", "font-weight: 700;");
            cp_no_label.removeAttribute("style");

            for (var i = 0; i < allOtherParticipantsInputs.length; i++) {
                if (allOtherParticipantsInputs[i].value != "") {
                   console.log("oth");
                   checkDone = "found";
                   break;
                }
            }

            if (checkDone === "found") {
                    
            } else if (checkDone === "init") {
                numberOfParticipantsConcerned = participants_number.value;
                participants_number.value = "0";
                for(var i=1; i<=numberOfParticipantsConcerned; i++) {
                    removeElement(i);
                }
            }
            
            pn_init = "0";
            opq_num.textContent = "How many other participants (besides you) will attend?";
            allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
        } else if (item.classList[0] === "cp_no") {
            allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
            cp_no_label.setAttribute("style", "font-weight: 700;");
            cp_yes_label.removeAttribute("style");

            for (var i = 0; i < allOtherParticipantsInputs.length; i++) {
                console.log(allOtherParticipantsInputs.length);
                if (allOtherParticipantsInputs[i].value != "") {
                   console.log("oth");
                   checkDone = "found";
                   break;
                }
            }

            if (checkDone === "found") {
                    
            } else if (checkDone === "init") {
                numberOfParticipantsConcerned = participants_number.value;
                participants_number.value = "1";
                for(var i=1; i<=numberOfParticipantsConcerned; i++) {
                    removeElement(i);
                }
                addElement(participants_number.value, (".op_dr_p0"));
            }
            
            pn_init = "1";
            opq_num.textContent = "How many participants will attend?";
            allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
        }
    })
});

// INCREMENT / DECREMENT
participants_minus.addEventListener('click', () => {
    if(participants_number.value > pn_init) {
        removeElement(participants_number.value);
        participants_number.value = --(participants_number.value);
        allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
    } else {
        participants_number.value = pn_init;
        allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
    }
});

participants_plus.addEventListener('click', () => {
    participants_number.value = ++(participants_number.value);
    x = ((participants_number.value)-1);
    addElement(participants_number.value, (".op_dr_p" + x));
    allOtherParticipantsInputs = document.querySelectorAll('.op_dr_any_input_label_group>input');
});

// RADIO PAYMENTS CHECK
radio_payments.forEach(radio => {
    radio.addEventListener('change', () => {
        for(var j = 0; j<radio_payments.length; j++) {
            if(j != ((radio.value)-1)) {
                place_to_show_checked[j].innerHTML = "";
            } else if (j == ((radio.value)-1)) {
                place_to_show_checked[j].innerHTML = "<i class=\"fa-solid fa-circle-check\"></i>";
            }
        }
    });
});