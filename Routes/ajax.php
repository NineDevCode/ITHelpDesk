<?php
session_start();
include "../Class/Class.php";

$hdc = new HDC();
$web = new Web();
$report = new Report();
$other = new Other();

if ($_REQUEST['ajax_name'] == 'hdc') {
    $result = $hdc->get_hdc_all();
    foreach ($result as $row) {
        $hdc_id = $row['hdc_id'];
        $status = '';
        $tool = '';

        if ($row['status'] == 'wait_accept') {
            $status = '<span class="bg-primary p-1 text-white rounded text-nowrap">รอรับงาน</span>';
            $tool = "<div class='d-flex'>
            <a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/hdc_info.php?hdc_id={$hdc_id}'>รายละเอียด</a>
            <a class='btn btn-sm btn-primary text-nowrap me-2' href='../../Backoffice/Admin/hdc_accept.php?hdc_id={$hdc_id}'>รับงาน</a>
            <a class='btn btn-sm btn-danger text-nowrap' href='../../Routes/routes.php?route_name=cancel_work_hdc&hdc_id={$hdc_id}'>ยกเลิกงาน</a>
            </div>";
        } else if ($row["status"] == "accepted") {
            $status = '<span class="bg-warning p-1 text-white rounded text-nowrap">กำลังดำเนินการ</span>';
            $tool = "            <a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/hdc_info.php?hdc_id={$hdc_id}'>รายละเอียด</a><a href='#modal-dialog-{$hdc_id}' class='btn btn-sm btn-success' data-bs-toggle='modal'>จบงาน</a>
            <div class='modal fade' id='modal-dialog-{$hdc_id}'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>จบงาน</h4>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-hidden='true'></button>
                    </div>
                    <form action='../../Routes/routes.php?route_name=finished_work_hdc&hdc_id={$hdc_id}' method='POST'>
                    <div class='modal-body'>
                        <textarea type='text' class='form-control' placeholder='รายละเอียดการจบงาน' rows='10' name='finish_detail'></textarea> 
                    </div>
                    <div class='modal-footer'>
                        <a href='javascript:;' class='btn btn-white' data-bs-dismiss='modal'>ยกเลิก</a>
                        <input class='btn btn-success' type='submit' value='ยืนยัน'>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            ";
        } else if ($row["status"] == "finished") {
            $status = '<span class="bg-success p-1 text-white rounded text-nowrap">ปิดงานแล้ว</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/hdc_info.php?hdc_id={$hdc_id}'>รายละเอียด</a>";
        } else if ($row["status"] == "cancel") {
            $status = '<span class="bg-danger p-1 text-white rounded text-nowrap">ยกเลิก</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/hdc_info.php?hdc_id={$hdc_id}'>รายละเอียด</a>";
        }
        $data[] = array(
            'hdc_id' => $row['hdc_id'],
            'name' => $row['titlename'] . $row['firstname'] . " " . $row['lastname'],
            'hoscode_name' => $row['name'],
            'department_name' => $row['department_name'],
            'email' => $row['email'],
            'tel' => $row['tel'],
            'status' => $status,
            'tool' => $tool,
        );
    }
    $response = array(
        "data" => $data
    );
    echo json_encode($response);
}
if ($_REQUEST['ajax_name'] == 'web') {
    $result = $web->get_web_all();
    foreach ($result as $row) {
        $web_id = $row['web_id'];
        $status = '';
        $tool = '';

        if ($row['status'] == 'wait_accept') {
            $status = '<span class="bg-primary p-1 text-white rounded text-nowrap">รอรับงาน</span>';
            $tool = "<div class='d-flex'>
            <a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/web_info.php?web_id={$web_id}'>รายละเอียด</a>
            <a class='btn btn-sm btn-primary text-nowrap me-2' href='../../Backoffice/Admin/web_accept.php?web_id={$web_id}'>รับงาน</a>
            <a class='btn btn-sm btn-danger text-nowrap' href='../../Routes/routes.php?route_name=cancel_work_web&web_id={$web_id}'>ยกเลิกงาน</a>
            </div>";
        } else if ($row["status"] == "accepted") {
            $status = '<span class="bg-warning p-1 text-white rounded text-nowrap">กำลังดำเนินการ</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/web_info.php?web_id={$web_id}'>รายละเอียด</a><a href='#modal-dialog-{$web_id}' class='btn btn-sm btn-success' data-bs-toggle='modal'>จบงาน</a>
            <div class='modal fade' id='modal-dialog-{$web_id}'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>จบงาน</h4>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-hidden='true'></button>
                    </div>
                    <form action='../../Routes/routes.php?route_name=finished_work_web&web_id={$web_id}' method='POST'>
                    <div class='modal-body'>
                        <textarea type='text' class='form-control' placeholder='รายละเอียดการจบงาน' rows='10' name='finish_detail'></textarea> 
                    </div>
                    <div class='modal-footer'>
                        <a href='javascript:;' class='btn btn-white' data-bs-dismiss='modal'>ยกเลิก</a>
                        <input class='btn btn-success' type='submit' value='ยืนยัน'>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            ";
        } else if ($row["status"] == "finished") {
            $status = '<span class="bg-success p-1 text-white rounded text-nowrap">ปิดงานแล้ว</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/web_info.php?web_id={$web_id}'>รายละเอียด</a>";
        } else if ($row["status"] == "cancel") {
            $status = '<span class="bg-danger p-1 text-white rounded text-nowrap">ยกเลิก</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/web_info.php?web_id={$web_id}'>รายละเอียด</a>";
        }
        $data[] = array(
            'web_id' => $row['web_id'],
            'name' => $row['titlename'] . $row['firstname'] . " " . $row['lastname'],
            'hoscode_name' => $row['name'],
            'department_name' => $row['department_name'],
            'email' => $row['email'],
            'tel' => $row['tel'],
            'status' => $status,
            'tool' => $tool,
        );
    }
    $response = array(
        "data" => $data
    );
    echo json_encode($response);
}
if ($_REQUEST['ajax_name'] == 'report') {
    $result = $report->get_report_all();
    foreach ($result as $row) {
        $report_id = $row['report_id'];
        $status = '';
        $tool = '';

        if ($row['status'] == 'wait_accept') {
            $status = '<span class="bg-primary p-1 text-white rounded text-nowrap">รอรับงาน</span>';
            $tool = "<div class='d-flex'>
            <a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/report_info.php?report_id={$report_id}'>รายละเอียด</a>
            <a class='btn btn-sm btn-primary text-nowrap me-2' href='../../Backoffice/Admin/report_accept.php?report_id={$report_id}'>รับงาน</a>
            <a class='btn btn-sm btn-danger text-nowrap' href='../../Routes/routes.php?route_name=cancel_work_report&report_id={$report_id}'>ยกเลิกงาน</a>
            </div>";
        } else if ($row["status"] == "accepted") {
            $status = '<span class="bg-warning p-1 text-white rounded text-nowrap">กำลังดำเนินการ</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/report_info.php?report_id={$report_id}'>รายละเอียด</a><a href='#modal-dialog-{$report_id}' class='btn btn-sm btn-success' data-bs-toggle='modal'>จบงาน</a>
            <div class='modal fade' id='modal-dialog-{$report_id}'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>จบงาน</h4>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-hidden='true'></button>
                    </div>
                    <form action='../../Routes/routes.php?route_name=finished_work_report&report_id={$report_id}' method='POST'>
                    <div class='modal-body'>
                        <textarea type='text' class='form-control' placeholder='รายละเอียดการจบงาน' rows='10' name='finish_detail'></textarea> 
                    </div>
                    <div class='modal-footer'>
                        <a href='javascript:;' class='btn btn-white' data-bs-dismiss='modal'>ยกเลิก</a>
                        <input class='btn btn-success' type='submit' value='ยืนยัน'>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            ";
        } else if ($row["status"] == "finished") {
            $status = '<span class="bg-success p-1 text-white rounded text-nowrap">ปิดงานแล้ว</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/report_info.php?report_id={$report_id}'>รายละเอียด</a>";
        } else if ($row["status"] == "cancel") {
            $status = '<span class="bg-danger p-1 text-white rounded text-nowrap">ยกเลิก</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/report_info.php?report_id={$report_id}'>รายละเอียด</a>";
        }
        $data[] = array(
            'report_id' => $row['report_id'],
            'name' => $row['titlename'] . $row['firstname'] . " " . $row['lastname'],
            'hoscode_name' => $row['name'],
            'department_name' => $row['department_name'],
            'email' => $row['email'],
            'tel' => $row['tel'],
            'status' => $status,
            'tool' => $tool,
        );
    }
    $response = array(
        "data" => $data
    );
    echo json_encode($response);
}
if ($_REQUEST['ajax_name'] == 'other') {
    $result = $other->get_other_all();
    foreach ($result as $row) {
        $other_id = $row['other_id'];
        $status = '';
        $tool = '';

        if ($row['status'] == 'wait_accept') {
            $status = '<span class="bg-primary p-1 text-white rounded text-nowrap">รอรับงาน</span>';
            $tool = "<div class='d-flex'>
            <a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/other_info.php?other_id={$other_id}'>รายละเอียด</a>
            <a class='btn btn-sm btn-primary text-nowrap me-2' href='../../Backoffice/Admin/other_accept.php?other_id={$other_id}'>รับงาน</a>
            <a class='btn btn-sm btn-danger text-nowrap' href='../../Routes/routes.php?route_name=cancel_work_other&other_id={$other_id}'>ยกเลิกงาน</a>
            </div>";
        } else if ($row["status"] == "accepted") {
            $status = '<span class="bg-warning p-1 text-white rounded text-nowrap">กำลังดำเนินการ</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/other_info.php?other_id={$other_id}'>รายละเอียด</a><a href='#modal-dialog-{$other_id}' class='btn btn-sm btn-success' data-bs-toggle='modal'>จบงาน</a>
            <div class='modal fade' id='modal-dialog-{$other_id}'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                    <div class='modal-header'>
                        <h4 class='modal-title'>จบงาน</h4>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-hidden='true'></button>
                    </div>
                    <form action='../../Routes/routes.php?route_name=finished_work_other&other_id={$other_id}' method='POST'>
                    <div class='modal-body'>
                        <textarea type='text' class='form-control' placeholder='รายละเอียดการจบงาน' rows='10' name='finish_detail'></textarea> 
                    </div>
                    <div class='modal-footer'>
                        <a href='javascript:;' class='btn btn-white' data-bs-dismiss='modal'>ยกเลิก</a>
                        <input class='btn btn-success' type='submit' value='ยืนยัน'>
                    </div>
                    </form>
                    </div>
                </div>
            </div>
            ";
        } else if ($row["status"] == "finished") {
            $status = '<span class="bg-success p-1 text-white rounded text-nowrap">ปิดงานแล้ว</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/other_info.php?other_id={$other_id}'>รายละเอียด</a>";
        } else if ($row["status"] == "cancel") {
            $status = '<span class="bg-danger p-1 text-white rounded text-nowrap">ยกเลิก</span>';
            $tool = "<a class='btn btn-sm btn-info text-nowrap me-2' href='../../Backoffice/Admin/other_info.php?other_id={$other_id}'>รายละเอียด</a>";
        }
        $data[] = array(
            'other_id' => $row['other_id'],
            'name' => $row['titlename'] . $row['firstname'] . " " . $row['lastname'],
            'hoscode_name' => $row['name'],
            'department_name' => $row['department_name'],
            'email' => $row['email'],
            'tel' => $row['tel'],
            'status' => $status,
            'tool' => $tool,
        );
    }
    $response = array(
        "data" => $data
    );
    echo json_encode($response);
}
?>