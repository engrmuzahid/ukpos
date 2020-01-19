<!DOCTYPE html>
<html lang="en">
    <head>
        <link href="<?php echo Yii::app()->request->baseUrl; ?>/public/css/bootstrap.min.css" rel="stylesheet" media="print" type="text/css"/>
        <style type="text/css">
            .border-all{
                border: 1px solid #000;
            }
            .border-left{
                border-left:  1px solid #000;
            }
            .border-right{
                border-right: 1px solid #000;
            }
            .border-top{
                border-top: 1px solid #000;
            }
            .border-bottom{
                border-bottom: 1px solid #000;
            }
            p{
                margin: 0px;
                padding: 10px 0;
            }
        </style>
    </head>
    <body>
        <div class="container" style="margin-top:100px;">
            <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  col-lg-12 col-sm-12 col-xs-12 badge-default text-center text-white">
                    <h2>MEMBERSHIP APPLICATION</h2>
                </div>
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-center" style="background-color: rgba(0, 0, 0, 0.05);">
                    <h4>BUSINESS INFORMATION</h4>
                </div>
            </div>
            <div class="row  border-all">
                <div class="col-md-7  col-lg-7 col-sm-7 col-xs-7  text-left">
                    <p style="font-size:20px;">Member ID : <?php echo $model->id; ?></p>
                </div>
                <div class="col-md-5  col-lg-5 col-sm-5 col-xs-5  text-left border-left">
                    <p style="font-size:20px;">Joining Date : <?php echo date("d M, Y", strtotime($model->joining_date)); ?></p>
                </div>
            </div>
            <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-left">
                    <p style="font-size:20px;">Business Name : <?php echo $model->business_name; ?></p>
                </div>

            </div>
            <div class="row  border-all">
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8  text-left">
                    <p style="font-size:20px;">Company Reg No. : <?php echo "N/A"; ?></p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">Business Tel : <?php echo $model->contact_no2; ?></p>
                </div>
            </div>
            <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-left">
                    <p style="font-size:20px;">Business Address : <?php echo $model->business_street1; ?></p>
                </div>

            </div>

            <div class="row  border-all">
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left">
                    <p style="font-size:20px;">City : <?php echo $model->business_city; ?></p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">State : <?php echo $model->business_state; ?></p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">Post Code : <?php echo $model->business_post_code; ?></p>
                </div>
            </div>

               
            
            
            
            
            <div class="row  border-all">
                 
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-center" style="background-color: rgba(0, 0, 0, 0.05);">
                    <h4>OWNER INFORMATION</h4>
                </div>
            </div>
        
            <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-left">
                    <p style="font-size:20px;">Owner Name : <?php echo $model->customer_name; ?></p>
                </div>

            </div>
            <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-left">
                    <p style="font-size:20px;">Owner Address : <?php echo $model->home_street1; ?></p>
                </div>

            </div>
              <div class="row  border-all">
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left">
                    <p style="font-size:20px;">City : <?php echo $model->home_city; ?></p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">State : <?php echo $model->home_state; ?></p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">Post Code : <?php echo $model->home_post_code; ?></p>
                </div>
            </div>
              <div class="row  border-all">
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left">
                    <p style="font-size:20px;">Home Phone : N/A </p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">Mobile : <?php echo $model->contact_no2; ?></p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">Email: <?php echo $model->email_address; ?></p>
                </div>
            </div>
                <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-left">
                    <p style="font-size:20px;">Position in Business : N/A</p>
                </div>

            </div>
            
                   
            <div class="row  border-all">
                 
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-center" style="background-color: rgba(0, 0, 0, 0.05);">
                    <h4> SIGNATURE </h4>
                </div>
            </div>
        
            <div class="row  border-all">
                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12  text-left">
                    <p style="font-size:17px;">  I certify that all information given in this application is correct to the best of my knowledge.By signing this form I/We accept and agree to be bound by the Terms and Conditions of Sylhet Cash and Curry Ltd.</p>
                </div>

            </div>
               <div class="row  border-all">
                <div class="col-md-8 col-lg-8 col-sm-8 col-xs-8  text-left">
                    <p style="font-size:20px;">Signature of Applicant : </p>
                </div>
                <div class="col-md-4  col-lg-4 col-sm-4 col-xs-4  text-left border-left">
                    <p style="font-size:20px;">Date : </p>
                </div> 
            </div>
            <br/>
          <br/>
          <br/>
          <br/>
          <br/>
        
            
        </div>
    </body>
</html>