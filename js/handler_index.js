let debug = false;

$(document).ready(function() {
    if (debug) {
        console.log("Get table request.");
    }

    $.ajax({
        url: "php/get_table.php",
        type: "GET",
        success: function (response) {
            addRowTable(response);
            if (debug) {
                console.log(response);
            }
        }
    })
});

function getX() {
    return Number($('input[name="radioGroup"]:checked').val());
}

function whiteColorInput() {
    $("#yValue").css("border", "1px solid #000000");
    $("#yValue").css("background", "WHITE");
}

function getAndCheckY() {
    let srcY = $("#yValue").val().replace(/,/,".");
    if (debug) {
        console.log("y = " + srcY);
    }

    if (srcY === "" || isNaN(srcY) || (Number(srcY) > 3 || Number(srcY) < -3)) {
        $("#yValue").css("border", "2px solid #f64072");
        $("#yValue").css("background", "#f5e0d9");
    } else {
        return Number(srcY);
    }
}

function selectR(button) {
    $('.selected').removeClass("selected").addClass("not_selected");
    button.classList.remove("not_selected");
    button.classList.add("selected")

    if (debug) {
        console.log("r = " + button.value);
    }
}

function buildRequest() {

    x = getX();
    y = getAndCheckY();
    r = $('.selected').val()

    if (debug) {
        console.log(x + " " + y + " " + r);
    }

    if (x !== undefined && y !== undefined && r !== undefined) {
        $.ajax({
            url: "php/handler_is_hit.php",
            type: "GET",
            data: {"x": x, "y": y, "r": r},
            success: function (response) {
                addRowTable(response);
            }
        });
    }
}

function addRowTable(data) {
    $("#tableResult").append(data);

    if (debug) {
        console.log(data);
    }
}