<hr />
    <table cellpadding="0" cellspacing="0" border="0" class="table table-bordered">
        <thead>
            <tr>
                <th><?php echo get_phrase('select_date');?></th>
                <th><?php echo get_phrase('select_month');?></th>
                <th><?php echo get_phrase('select_year');?></th>
                
            
           </tr>
       </thead>
        <tbody>
            <form method="post" action="<?php echo base_url();?>index.php?admin/attendance_selector" class="form">
                <tr class="gradeA">
                    <td>
                        <select name="date" class="form-control">
                            <?php for($i=1;$i<=31;$i++):?>
                                <option value="<?php echo $i;?>" 
                                    <?php if(isset($date) && $date==$i)echo 'selected="selected"';?>>
                                        <?php echo $i;?>
                                            </option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <td>
                        <select name="month" class="form-control">
                            <?php 
                            for($i=1;$i<=12;$i++):
                                if($i==1)$m='january';
                                else if($i==2)$m='february';
                                else if($i==3)$m='march';
                                else if($i==4)$m='april';
                                else if($i==5)$m='may';
                                else if($i==6)$m='june';
                                else if($i==7)$m='july';
                                else if($i==8)$m='august';
                                else if($i==9)$m='september';
                                else if($i==10)$m='october';
                                else if($i==11)$m='november';
                                else if($i==12)$m='december';
                            ?>
                                <option value="<?php echo $i;?>"
                                    <?php if($month==$i)echo 'selected="selected"';?>>
                                        <?php echo $m;?>
                                            </option>
                            <?php 
                            endfor;
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="year" class="form-control">
                            <?php for($i=2020;$i>=2010;$i--):?>
                                <option value="<?php echo $i;?>"
                                    <?php if(isset($year) && $year==$i)echo 'selected="selected"';?>>
                                        <?php echo $i;?>
                                            </option>
                            <?php endfor;?>
                        </select>
                    </td>
                    <!--<td>
                        <select name="class_id" class="form-control">
                            <option value="">Select a class</option>
                            <?php 
                            $classes    =   $this->db->get('class')->result_array();
                            foreach($classes as $row):?>
                            <option value="<?php echo $row['class_id'];?>"
                                <?php if(isset($class_id) && $class_id==$row['class_id'])echo 'selected="selected"';?>>
                                    <?php echo $row['name'];?>
                                        </option>
                            <?php endforeach;?>
                        </select>

                    </td>-->
                   
                </tr>
            </form>
        </tbody>
    </table>
<hr />



<?php if($date!='' && $month!='' && $year!='' ):?>

<center>
    <div class="row">
        <div class="col-sm-offset-4 col-sm-4">
        
            <div class="tile-stats tile-white-gray">
                <div class="icon"><i class="entypo-suitcase"></i></div>
                <?php
                    $full_date  =   $year.'-'.$month.'-'.$date;
                    $timestamp  = strtotime($full_date);
                    $day        = strtolower(date('l', $timestamp));
                 ?>
                <h2><?php echo ucwords($day);?></h2>
                
                <h3>Attendance of Teacher </h3>
                <p><?php echo $date.'-'.$month.'-'.$year;?></p>
            </div>
            <a href="#" id="update_attendance_button" onclick="return update_attendance()" 
                class="btn btn-info">
                    Manage Attendance
            </a>
        </div>

    </div>
</center>
<hr />

<div class="row" id="attendance_list">
    <div class="col-sm-offset-3 col-md-6">
        <table class="table table-bordered">
            <thead>
                <tr>
                    
                    <td><span class="badge badge-pill badge-info"><?php echo get_phrase('_Name');?></span></td>
                    <td><span class="badge badge-pill badge-info"><?php echo get_phrase('_Subject');?></span></td>
                    <td><span class="badge badge-pill badge-info"><?php echo get_phrase('_Status');?></span></td>

                </tr>
            </thead>
            <tbody>

                <?php 
                    $students   =   $this->db->get_where('teacher')->result_array();
                        foreach($students as $row):?>
                        <tr class="gradeA">
                            
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['subject'];?></td>


                            <?php 
                                
                                 $verify_data    =   array(  'teacher_id' => $row['teacher_id'],
                                                            'date' => $full_date);
                                $query = $this->db->get_where('attendance' , $verify_data);
                                if($query->num_rows() < 1)
                                $this->db->insert('attendance' , $verify_data);
                                //showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                                $status     = $attendance->status;
                            ?>
                        <?php if ($status == 1):?>
                            <td align="center">
                              <span class="badge badge-success"><?php echo get_phrase('present');?></span>  
                            </td>
                        <?php endif;?>
                        <?php if ($status == 2):?>
                            <td align="center">
                              <span class="badge badge-danger"><?php echo get_phrase('absent');?></span>  
                            </td>
                        <?php endif;?>
                        <?php if ($status == 0):?>
                            <td align="center">
                            <span class="badge badge-dark"><?php echo get_phrase('UnMarked');?></span> 
                            </td>
                        </td>
                        <?php endif;?>
                        </tr>
                    <?php endforeach;?>
            </tbody>
        </table>
    </div>
</div>




<div class="row" id="update_attendance">

<!-- STUDENT's attendance submission form here -->
<form method="post" 
    action="<?php echo base_url();?>index.php?admin/manage_attendance/<?php echo $date.'/'.$month.'/'.$year.'/'.$class_id;?>">
        <div class="col-sm-offset-3 col-md-6">
            <table  class="table table-bordered">
                <thead>
                    <tr class="gradeA">
                        <th><?php echo get_phrase('name');?></th>
                        <th><?php echo get_phrase('subject');?></th>
                        <th><?php echo get_phrase('status');?></th>
                    </tr>
                </thead>
                <tbody>
                        
                    <?php 
                    //Teacher ATTENDANCE
                    $teachers   =   $this->db->get_where('teacher')->result_array();
                        
                    foreach($teachers as $row)
                    {
                        ?>
                        <tr class="gradeA">
                            <td><?php echo $row['name'];?></td>
                            <td><?php echo $row['subject'];?></td>
                            <td align="center">
                                <?php 
                                //inserting blank data for students attendance if unavailable
                                
                                
                                //showing the attendance status editing option
                                $attendance = $this->db->get_where('attendance' , $verify_data)->row();
                                $status     = $attendance->status;
                                ?>
                                
                                
                                    <select name="status_<?php echo $row['teacher_id'];?>" class="form-control" style="width:100px; float:left;">
                                        <option value="0" <?php if($status == 0)echo 'selected="selected"';?>></option>
                                        <option value="1" <?php if($status == 1)echo 'selected="selected"';?>>Present</option>
                                        <option value="2" <?php if($status == 2)echo 'selected="selected"';?>>Absent</option>
                                    </select>
                                
                            </td>
                        </tr>
                        <?php 
                    }
                    ?>
                </tbody>
            </table>
            <input type="hidden" name="date" value="<?php echo $full_date;?>" />
            <center>
                <input type="submit" class="btn btn-info" value="save changes">
            </center>
        </div>
    
    
</form>
</div>
<?php endif;?>

<script type="text/javascript">

    $("#update_attendance").hide();

    function update_attendance() {

        $("#attendance_list").show();
        $("#update_attendance_button").hide();
        $("#update_attendance").show();

    }
</script>