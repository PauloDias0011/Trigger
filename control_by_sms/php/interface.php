<?php
/********************************************************
 *
 * Author: Vitor Rozsa
 * email: vd5_@hotmail.com
 *
 * Brief: Functions that will build the schedule page.
 *******************************************************/

/* global */
$TBL_SIZE = 10;

/********************************************************
 * Brief: Build a table/list from the given parameter.
 */
function build_contacts_table($users)
{
    global $TBL_SIZE;
    $table.= "<select multiple=\"multiple\" id=\"avaliable_users_select\" name=\"avaliable_users\" size=\"$TBL_SIZE\">";
    $table.= "<optgroup label=\"Avaliable\")\">";
    
    while($user = pg_fetch_row($users)) {
    	$table.= "<option name=\"$user[2]\" value=\"$user[2]\">$user[2] - $user[0] $user[1]</option>";
    }
    
    $table.= "</optgroup>";
    $table.= "</select>";
    
    return $table;
}
/********************************************************
 * Brief: Build a clear table to receive selected users.
 */
function build_empty_table()
{
    global $TBL_SIZE;
    $table.= "<select name=\"destination_users_select[]\" id=\"destination_users_select\" multiple=\"multiple\" size=\"$TBL_SIZE\">";
    $table.= "<optgroup label=\"Selected\">";
    $table.= "</optgroup>";
    $table.= "</select>";
    
    return $table;
}
/********************************************************
 * Brief: Build the header.
 */
function build_header()
{
    $header.= "<html><head>";
    $header.= "<title>Control by SMS - Schedule</title>";
    $header.= "<script src=\"./js/interface.js\"></script>";
    $header.= "<script src=\"./js/validate.js\"></script>"; 
    $header.= "<LINK REL=StyleSheet HREF=\"/moodle/theme/standard/style/core.css\" TYPE=\"text/css\" MEDIA=screen>";
    $header.= "<LINK REL=StyleSheet HREF=\"style/plugin_style.css\" TYPE=\"text/css\" MEDIA=screen>";
    $header.= "</head><body>";
    $header.= "<h1 align=\"center\">SMS Service</h1>";

    return $header;
}
/********************************************************
 * Brief: Build the tail.
 */
function build_tail()
{
    return "</body></html>";
}
/********************************************************
 * Brief: Build table interact buttons.
 */
function build_table_buttons()
{
    $button.= "<input type=\"button\" value=\"&larr; Rem Item\" onclick=\"removeSelected();\" />";
    $button.= "<input type=\"button\" value=\"Add Item &rarr;\" onclick=\"addSelected();\" />";
    
    return $button;
}
/********************************************************
 * Brief: Build form that will receive message and 
 *      options.
 */
function build_input_form($origin)
{
    $form.= "<table>";

    $form.= "<tr><td>";
    $form.= "Origin:<br /><input name=\"origin\" type=\"text\" value=\"$origin\" maxlength=7 size=22>";
    $form.= "</td></tr>";

    $form.= "<tr><td>";
    $form.= "<textarea rows=\"8\" cols=\"19\" name=\"message\" maxlength=149></textarea><br />M&aacute;x.149 caracteres";
    $form.= "</td></tr>";

    $form.= "<tr><td>";
    $form.= "<input type=\"radio\" name=\"sms_action\" id=\"sms_action0\" checked=\"yes\" value=\"0\" />Instant SMS";
    $form.= "</td></tr>";

    $form.= "<table style=\"border:2px inset;\">";
        $form.= "<tr><td>";
            $form.= "<input type=\"radio\" name=\"sms_action\" id=\"sms_action1\" value=\"1\" />Schedule SMS";
        $form.= "</td></tr>";

        $form.= "<tr><td>";
            $form.= "Date:<br /><input name=\"date\" type=\"text\">";
        $form.= "</td></tr>";

        $form.= "<tr><td>";
            $form.= "Time (HH:MM format):<br /><input name=\"time\" type=\"text\" maxlength=5>";
        $form.= "</td></tr>";
    $form.= "</table>";

    $form.= "<tr><td style=\"border-style:none;text-align:center;\">";
    $form.= "<input type=\"submit\" value=\"Register\">";
    $form.= "</td></tr>";

    $form.= "</table>";

    return $form;
}

function build_select_group_input() 
{
    $form.= "<form method=\"get\" action=\"schedule_sms.php\">";
    $form.= "Insert a destination group (by shortname):<br />";
    $form.= "<input name=\"course_group\" type=\"text\" maxlength=10>";
    $form.= "<input type=\"submit\" value=\"Retrive students\">";
    $form.= "</form>";

    return $form;
}

function mount_date($date_obj)
{
    $date.= $date_obj->hour . ":" . $date_obj->minute;
    $date.= " - ";
    $date.= $date_obj->day . "/" . $date_obj->month . "/" . $date_obj->year;

    return $date;
}

function treat_str($msg)
{
    if(strlen($msg) >= 60) {
        $msg_ret.= substr($msg, 0, 54) . "<br />";
        $msg_ret2.= substr($msg, 54);

        if(strlen($msg_ret2) >= 60) {
            $msg_ret.= substr($msg_ret2, 0, 54) . "<br />";
            $msg_ret.= substr($msg_ret2, 54);

        } else {
            $msg_ret.= $msg_ret2;
        }

        return $msg_ret;

    } else {
        return $msg;
    }
}
?>
