<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function StringRepair($temptext)
{
    $temptext = trim($temptext);
    $temptext = str_replace("'", "&#39;", $temptext);
    $temptext = str_replace("\"", "&#34;", $temptext);
    return $temptext;
}
function StringRepair3($temptext)
{
    $temptext = trim($temptext);
    $temptext = str_replace("&#39;", "'", $temptext);
    $temptext = str_replace("&#34;", "\"", $temptext);
    return $temptext;
}
function PageConfig($baseurl, $total_records, $limit_per_page, $uriseg)
{
    $config = array();
    // get current page records
    $config['base_url'] = $baseurl;
    $config['total_rows'] = $total_records;
    $config['per_page'] = $limit_per_page;
    $config["uri_segment"] = $uriseg;
    $config['attributes'] = array('class' => 'page-link');

    $config['full_tag_open'] = '<hr><ul class="pagination pagination-sm p-b-10 justify-content-center">';
    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = '« First';
    $config['first_tag_open'] = '<li class="previous">';
    $config['first_tag_close'] = '</li>';

    $config['last_link'] = 'Last »';
    $config['last_tag_open'] = '<li class="next">';
    $config['last_tag_close'] = '</li>';

    $config['next_link'] = 'Next';
    $config['next_tag_open'] = '<li class="next">';
    $config['next_tag_close'] = '</li>';

    $config['prev_link'] = 'Previous';
    $config['prev_tag_open'] = '<li class="previous">';
    $config['prev_tag_close'] = '</li>';

    $config['cur_tag_open'] = '<li class="active page-item"><a href="" class="page-link">';
    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li class="page-item">';
    $config['num_tag_close'] = '</li>';

    return $config;
}
function Actdeact($act)
{
    $btnval = "";
    if ($act == 1) :
        $btnval = '<label class="btn btn-primary btn-sm m-b-3">Activated</label>';
    else :
        $btnval = '<label class="btn btn-danger btn-sm m-b-3">Deactivated</label>';
    endif;

    return $btnval;
}
function checkSession()
{
    $CI = &get_instance();
    if (isset($CI->session->userdata['logged_in'])) {
        $userid = $CI->session->userdata['logged_in']['userid'];
        $sessionid = $CI->session->userdata['logged_in']['user_session'];
        $query = "select user_session from " . TBL_USERINFO . " where id=" . $userid . " and user_session='" . $sessionid . "'";
        $res = $CI->Queries->getSingleRecord($query);
        if ($res == null) {
            $CI->session->set_flashdata('success_msg', "Another User Might Be LoggedIn");
            redirect('');
        }
    } else {
        redirect('');
    }
}
function alertbox()
{
    $CI = &get_instance();
    if ($msg = $CI->session->flashdata('error_msg')) :
        echo ' <div class="alert alert-danger dark alert-dismissable p5"><strong>' . $msg . '</strong> </div>';
    endif;
    if ($msg = $CI->session->flashdata('error')) :
        echo ' <div class="alert alert-danger dark alert-dismissable p5"><strong>' . $msg . '</strong> </div>';
    endif;
    if ($msg = $CI->session->flashdata('success_msg')) :
        echo ' <div class="alert alert-success dark alert-dismissable p5"><strong>' . $msg . '</strong> </div>';
    endif;
    if ($msg = $CI->session->flashdata('message')) :
        echo ' <div class="alert alert-success dark alert-dismissable p5"><strong>' . $msg . '</strong> </div>';
    endif;
    echo validation_errors('<div class="alert alert-danger dark alert-dismissable p5">', '</div>');
}
function manageheader($managePage = "", $addPage = "", $addButton = "")
{
    echo '<div class="panel panel-default panel-border top">
                <div class="panel-heading">
                    <div class="row">
                    <div class="col-sm-6">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">' . $managePage . '</li>
                    </ul>
                    </div>';
    if ($addPage != "" && $addButton != "") {
        echo '          <div class="col-sm-6">' .
            anchor($addPage, '<i class="ti-plus text-primary f-s-18 pull-left m-r-10 "></i>' . $addButton . '</a > ', ['class' => 'btn btn-outline btn-primary m-b-3', 'style' => 'float:right;"']) . '
                    </div>';
    }
    echo '  </div>
                </div>
                </div>';
}
/* function noRecord($addPage)
{
    echo '<div class="panel-body">
                            <p>No Record(s) added yet.</p>';
    if ($addPage != "") {
        echo '<a href="' . $addPage . '" class="btn btn-primary float-left btn-gradient btn-alt" style="margin-left:15px;" > <i class="font-icon font-icon-plus"></i> Add Record</a>';
    }
    echo ' </div>';
} */
function noRecord($addPage = "")
{
    echo '<div class="row">
                ';
    if ($addPage != "") {
        echo '
                            <div style="float:left; margin-top: 20px;padding-left: 50px;" >
                            <p>No Record(s) added yet.</p>
                            </div>';
    }
    echo '</div>  ';
}

function labelbox($colname = "", $label = "", $value = "")
{
    echo '<div class="col-md-' . $colname . '">
              <fieldset class="form-group">
              <label class="form-label semibold">' . $label . '</label>
              <label class="form-control">' . $value . '</label>
              </fieldset>
            </div>';
}
function editbox($labelname = "", $fieldname = "", $placeholder = "", $value = "", $jquery = "")
{
    echo ' <fieldset class="form-group">
    <label class="form-label">' . $labelname . '</label>
        <input type="text" name="' . $fieldname . '" id="' . $fieldname . '" class="form-control" placeholder="' . $placeholder . '" value="' . $value . '" autocomplete="off" ' . $jquery . ' onfocus="this.setSelectionRange(0, this.value.length)">
     
</fieldset>';
}
function numberbox($labelname = "", $fieldname = "", $placeholder = "", $value = "", $jquery = "")
{
    echo ' <fieldset class="form-group">
<label class="form-label">' . $labelname . '</label>
    <input type="number" name="' . $fieldname . '" id="' . $fieldname . '" class="form-control" placeholder="' . $placeholder . '" value="' . $value . '" autocomplete="off" ' . $jquery . ' onfocus="this.setSelectionRange(0, this.value.length)">
 
</fieldset>';
}
function pricebox($labelname = "", $fieldname = "", $placeholder = "", $value = "")
{
    echo ' <fieldset class="form-group">
    <label class="form-label">' . $labelname . '</label>
        <input type="number" step="any" name="' . $fieldname . '" id="' . $fieldname . '" class="form-control" placeholder="' . $placeholder . '" value="' . $value . '" autocomplete="off" ' . $jquery . ' onClick="this.setSelectionRange(0, this.value.length)">
     
</fieldset>';
}
function textareabox($label = "", $fieldname = "", $placeholder = "", $value = "")
{
    echo '
            <fieldset class="form-group">
                <label class="form-label semibold">' . $label . '</label>
                ' . form_textarea(['name' => $fieldname, 'id' => $fieldname, 'value' => $value, 'placeholder' => $placeholder, 'class' => 'form-control', 'style' => 'height:100px;']) . '
            </fieldset>
            ';
}
function emailbox($labelname, $fieldname = "", $placeholder = "", $value = "", $required = "")
{
    echo ' <fieldset class="form-group">
    <label class="form-label">' . $labelname . '</label>  <input type="email" ' . $required . ' name="' . $fieldname . '" id="' . $fieldname . '" class="gui-input" placeholder="' . $placeholder . '" value="' . $value . '" autocomplete="off" onClick="this.setSelectionRange(0, this.value.length)" >
        
</fieldset>';
}
function passwordbox($labelname, $fieldname = "", $placeholder = "", $value = "", $required = "")
{
    echo ' <fieldset class="form-group">
    <label class="form-label">' . $labelname . '</label>  
    <input type="password" ' . $required . ' name="' . $fieldname . '" id="' . $fieldname . '" class="gui-input" placeholder="' . $placeholder . '" value="" autocomplete="off" >   
</fieldset>';
}

function dropdownbox($labelname = "", $fieldname = "", $array = "", $value = "", $jscript = "")
{

    $attributes = ' class="select2-single form-control" style="width:100%;" ' . $jscript . ' id="' . $fieldname . '"';
    echo '<fieldset class="form-group ' . $fieldname . '">
    <label class="form-label">' . $labelname . '</label>';
    echo form_dropdown($fieldname, $array, $value, $attributes);
    echo '</fieldset>';
}

function multidropdownbox($labelname = "", $fieldname = "", $array = "", $value = "", $jscript = "")
{

    $attributes = 'class="select2-multiple form-control select-primary" multiple="multiple" ' . $jscript . ' id="' . $fieldname . '"';
    echo '<fieldset class="form-group">
    <label class="form-label">' . $labelname . '</label>
    <div class="clearfix"></div>';
    echo form_dropdown($fieldname, $array, $value, $attributes);
    echo '</fieldset>';
}

function datepicker($labelname = "", $fieldname = "", $placeholder = "", $value = "")
{
    echo '
    <fieldset class="form-group">
    <label class="form-label">' . $labelname . '</label>
    <div class="input-group date ">
        <input type="date" class="form-control" id="' . $fieldname . '" name="' . $fieldname . '" value="' . $value . '" style="padding:0 10px;">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
    </div>
    </fieldset>
';
}

function timepicker($colname = "", $label = "", $fieldname = "", $placeholder = "", $value = "")
{
    echo '<div class="col-md-' . $colname . '">
            <div class="form-group">
                                    <label class="control-label">' . $label . '</label>
                                    <div class="input-group bootstrap-timepicker timepicker">
                                        <input id="' . $fieldname . '" type="text" class="form-control" name="' . $fieldname . '" value="' . $value . '">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                    </div>
                                </div>
            </div>';
}
function checkbox($check = "", $label = "", $fieldname = "")
{
    $checked = "";
    if ($check == 1) {
        $checked = "checked";
    }

    echo '<div class="section">
    <label class="switch block mt15 switch-primary">
        <input type="checkbox" name="' . $fieldname . '" id="' . $fieldname . '" value="1" ' . $checked . '>
        <label for="' . $fieldname . '" data-on="ON" data-off="OFF"></label>
        <span>' . $label . '</span>
    </label>

</div>
';
}

function uploadbox($colname = "", $label = "", $fieldname = "", $placeholder = "", $accept = "")
{
    echo '<div class="col-md-' . $colname . ' admin-form">
                        <div class="section" >
                            <label class="field prepend-icon append-button file" style="margin-top:22px;">
                                <span class="button btn-default">Choose File</span>
                                <input class="gui-file" name="' . $fieldname . '"accept="' . $accept . '" id="' . $fieldname . '" onchange="document.getElementById(\'' . $fieldname . '_1\').value = this.value;" type="file">
                                <input class="gui-input" id="' . $fieldname . '_1" placeholder="' . $placeholder . '" type="text">
                                <label class="field-icon">
                                    <i class="ti-upload"></i>
                                </label>
                            </label>
                        </div>
                        </div>';
}
function multiuploadbox($colname = "", $label = "", $fieldname = "", $placeholder = "")
{
    echo '<div class="col-md-' . $colname . ' admin-form">
                        <div class="section" >
                            <label class="field prepend-icon append-button file" style="margin-top:22px;">
                                <span class="button btn-default">' . $label . '</span>
                                <input class="gui-file" name="' . $fieldname . '" id="' . $fieldname . '" multiple="multiple" onchange="document.getElementById(\'' . $fieldname . '_1\').value = this.value;" type="file">
                                <input class="gui-input" id="' . $fieldname . '_1" placeholder="' . $placeholder . '" type="text">
                                <label class="field-icon">
                                    <i class="fa fa-upload"></i>
                                </label>
                            </label>
                        </div>
                        </div>';
}
function submitbutton($pageBack = "")
{
    echo '
    <input type="submit" name="submit" class="button btn-primary btn-xs" value="Save" />
    <button type="reset" class="button btn-danger btn-xs"> Cancel </button>
    ';
}

function customData($arraydata, $cid)
{

    foreach ($arraydata as $column => $value) {
        if ($cid == $column) {
            return $value;
        }
    }
}


/* HRMS HELPER FUNCTIONS */
function check_role_assigned($module_name, $role_type)
{
    $ci = &get_instance();
    $logged_in_role = $ci->session->logged_in['user_role'];
    $user_role = $ci->session->logged_in['user_type'];
    if ($user_role == '1') { //1 For Super Admin
        return 1;
    }
    $logged_in_role_arr = json_decode($logged_in_role);
    if (isset($logged_in_role_arr->{$module_name}) && isset($logged_in_role_arr->{$module_name}->{$role_type}) && $logged_in_role_arr->{$module_name}->{$role_type} == 1)
        return 1;
    else
        return 0;
}
function set_menu_item($menu)
{

    if (check_role_assigned($menu['role'], 'view')) {



        if (isset($menu['submenu']) && count($menu['submenu'])) {
            $str = ' <li><a class="accordion-toggle" href="#"> <span class="' . $menu['class'] . '"></span> <span class="sidebar-title">' . $menu['name'] . '</span> <span class="caret"></span> </a><ul class="nav sub-nav">';

            foreach ($menu['submenu'] as $sub) {
                $str .= set_menu_item($sub);
            }
            $str .= '</ul></li>';
        } else {

            $str = '<li> <a href="' . base_url() . $menu['url'] . '"> <i class="' . $menu['class'] . '"></i><span>' . $menu['name'] . '</span> </a>';
            $str .= '</li>';
        }

        return $str;
    } else {
        return '';
    }
}

function set_menu_role($menu, $val_role_details)
{
    $menu_slug = $menu->role;
    if (isset($menu->submenu) && count($menu->submenu)) {
        $checked_view = '';
        $checked_add = '';
        $checked_edit = '';
        $checked_delete = '';
        $checked_allocation = '';
        $checked_export = '';
        $checked_allrecord = '';
        $checked_executive = '';
        if (isset($val_role_details->{$menu_slug}->view)) {
            $checked_view = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->add)) {
            $checked_add = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->edit)) {
            $checked_edit = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->delete)) {
            $checked_delete = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->allocation)) {
            $checked_allocation = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->export)) {
            $checked_export = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->allrecord)) {
            $checked_allrecord = 'checked';
        }
        if (isset($val_role_details->{$menu_slug}->executive)) {
            $checked_executive = 'checked';
        }

        $str = ' <li>' . $menu->name . ' <label>';
        if (strpos($menu->role_type, 'view') !== false)
            $str .= '<input type="checkbox" name="role[' . $menu_slug . '][view]" value="1" ' . $checked_view . ' > View </label>';
        if (strpos($menu->role_type, 'add') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][add]" value="1" ' . $checked_add . ' > Add </label>';
        if (strpos($menu->role_type, 'edit') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][edit]" value="1" ' . $checked_edit . '> Edit </label>';
        if (strpos($menu->role_type, 'delete') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][delete]" value="1" ' . $checked_delete . ' > Delete </label>';
        if (strpos($menu->role_type, 'allocation') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][allocation]" value="1" ' . $checked_allocation . ' > Allocation </label>';
        if (strpos($menu->role_type, 'export') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][export]" value="1" ' . $checked_export . ' > Export </label>';
        if (strpos($menu->role_type, 'allrecord') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][allrecord]" value="1" ' . $checked_allrecord . ' > All Records </label>';
        if (strpos($menu->role_type, 'executive') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][executive]" value="1" ' . $checked_executive . ' > As Executive </label>';
        $str .= '<ul>';

        foreach ($menu->submenu as $sub) {
            $str .= set_menu_role($sub, $val_role_details);
        }
        $str .= '</ul></li>';
    } else {

        $checked_view = '';
        $checked_add = '';
        $checked_edit = '';
        $checked_delete = '';
        $checked_allocation = '';
        $checked_export = '';
        $checked_allrecord = '';
        $checked_executive = '';
        if (isset($val_role_details->{$menu_slug}->view)) {
            $checked_view = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->add)) {
            $checked_add = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->edit)) {
            $checked_edit = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->delete)) {
            $checked_delete = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->allocation)) {
            $checked_allocation = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->export)) {
            $checked_export = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->allrecord)) {
            $checked_allrecord = 'checked';
        }

        if (isset($val_role_details->{$menu_slug}->executive)) {
            $checked_executive = 'checked';
        }

        $str = ' <li>' . $menu->name;
        if (strpos($menu->role_type, 'view') !== false)
            $str .= '
            <div class="switcher switcher-success">
                <input name="role[' . $menu_slug . '][view]"  id="role[' . $menu_slug . '][view]"  value="1" type="checkbox" ' . $checked_view . ' >
                <label for="role[' . $menu_slug . '][view]"></label>
            </div>';
        if (strpos($menu->role_type, 'add') !== false)
            $str .= ' <div class="switcher switcher-info">
            <input name="role[' . $menu_slug . '][add]"  id="role[' . $menu_slug . '][add]"  value="1" type="checkbox" ' . $checked_add . ' >
            <label for="role[' . $menu_slug . '][add]"></label>
        </div>
        ';
        if (strpos($menu->role_type, 'edit') !== false)
            $str .= ' <div class="switcher switcher-warning">
            <input name="role[' . $menu_slug . '][edit]"  id="role[' . $menu_slug . '][edit]"  value="1" type="checkbox" ' . $checked_edit . ' >
            <label for="role[' . $menu_slug . '][edit]"></label>
        </div>';
        if (strpos($menu->role_type, 'delete') !== false)
            $str .= ' <div class="switcher switcher-danger">
            <input name="role[' . $menu_slug . '][delete]"  id="role[' . $menu_slug . '][delete]"  value="1" type="checkbox" ' . $checked_delete . ' >
            <label for="role[' . $menu_slug . '][delete]"></label>
        </div>';
        if (strpos($menu->role_type, 'allocation') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][allocation]" value="1" ' . $checked_allocation . ' > Allocation </label>';
        if (strpos($menu->role_type, 'export') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][export]" value="1" ' . $checked_export . ' > Export </label>';
        if (strpos($menu->role_type, 'allrecord') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][allrecord]" value="1" ' . $checked_allrecord . ' > All Record </label>';
        if (strpos($menu->role_type, 'executive') !== false)
            $str .= '<label><input type="checkbox" name="role[' . $menu_slug . '][executive]" value="1" ' . $checked_executive . ' > As Executive </label>';
    }
    return $str;
}
function slugify($text)
{
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
}

function create_time_range($start, $end, $interval = '30 mins', $format = '12')
{
    $startTime = strtotime($start);
    $endTime = strtotime($end);
    $returnTimeFormat = ($format == '12') ? 'g:i A' : 'H:i';

    $current = time();
    $addTime = strtotime('+' . $interval, $current);
    $diff = $addTime - $current;

    $times = array();
    while ($startTime < $endTime) {
        $times[] = date($returnTimeFormat, $startTime);
        $startTime += $diff;
    }
    $times[] = date($returnTimeFormat, $startTime);
    return $times;
}

function sendMessage($mobile = "", $message = "")
{

    $ci = &get_instance();
    $form_data = array(
        'mobile' => $mobile,
        'msg' => $message
    );
    $ci->Queries->addRecord(TBL_SENDMSG, $form_data);
    $message = urlencode($message . $footer);
    $cgurl = "http://login.smshisms.com/API/WebSMS/Http/v1.0a/index.php?username=infinity001&password=123456&sender=INFICT&to=" . $mobile . "&message=" . $message . "&reqid=1&format={json|text}&route_id=7&sendondate=" . date('d-m-Y+H:i:s');
    //echo $cgurl;
    $output = file_get_contents($cgurl);
}

function checkbox1($check = "", $label = "", $fieldname = "", $value = "", $class = "")
{
    $checked = "";
    if ($check == 1) {
        $checked = " checked";
    }

    echo '<div class="section">
    <label class="switch block mt15 switch-primary">
        <input type="checkbox" name="' . $fieldname . '" id="' . $fieldname . '" class="' . $class . '" value="' . $value . '" ' . $checked . '>
        <label for="' . $fieldname . '" data-on="Yes" data-off="No"></label>
        <span>' . $label . '</span>
    </label>

</div>
';
}
