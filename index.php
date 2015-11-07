<!DOCTYPE html>
<html lang="en">
    <head>
        <title>DDAWO</title>
        <meta charset="utf-8" />
        <meta name="author" content="Harish Mohan">
        <meta name="description" content="District Differently Ablef Welfare Office">
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.3.14/angular.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.15/angular-sanitize.min.js"></script>
        <link rel="stylesheet" href="css/bootstrap-upload-file-button.css" />
        <script src="js/bootstrap-upload-file-button.min.js"></script>
        <script src="js/dirPagination.min.js"></script>
        <script src="js/ng-csv.min.js"></script>
        <style>
            img { height: 50px; width: 50px; }
            #user-photo { height: 200px; width: 170px; }
        </style>
    </head>
    <body ng-app="ddawoApp" ng-controller="ddawoCtrl">
        <?php
            $id_collision_flag = false;
            if(isset($_POST['submit'])) {
                $con = new mysqli("127.0.0.1", "root", "", "ddawo");
                if($con->connect_errno === 0) {
                    $target_dir = "uploads/";
                    if(isset($_FILES["pphoto"])) {
                        $target_file = $target_dir . basename($_FILES["pphoto"]["name"]);
                        move_uploaded_file($_FILES["pphoto"]["tmp_name"], $target_file);
                    }
                    unset($_POST['submit']);
                    $data = implode("','", $_POST);
                    $sql = "insert into ddawo.users values('{$data}','{$target_file}')";
                    if(!$con->query($sql)) {
                        $id_collision_flag = true;
                    }
                    $con->close();
                }
            }
        ?>
        <nav class="navbar navbar-inverse">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a class="navbar-brand" href="#">DDAWO</a>
                    </div>
                    <div>
                        <ul class="nav navbar-nav">
                            <li id="form-menu" data-ng-click="form()"><a href="#">Register</a></li>
                            <li id="list-menu" data-ng-click="list()"><a href="#">List Users</a></li>
                            <li id="view-menu" data-ng-click="view()"><a href="#">View User</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        <div class="container">
            <div id="form" data-ng-hide="formFlag">
                <h2 class="text-center">Registration Form</h2>
                <hr>
                <?php if($id_collision_flag) { echo "<span class='form-group text-center text-danger col-sm-12'><b>National ID Card No Already Exists!</b></span>"; } ?>
                <form class="form-horizontal" role="form" name="registration" action="index.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="nationalid" class="control-label col-sm-3">National ID Card No: </label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="nationalid" name="nationalid" placeholder="Enter National ID Card No" autofocus required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="name" class="control-label col-sm-3">Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="dob" class="control-label col-sm-3">Date Of Birth: </label>
                        <div class="col-sm-9">
                            <input type="date" class="form-control" id="dob" name="dob" data-ng-model="dob" data-ng-blur="getAge()" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="age" class="control-label col-sm-3">Age: </label>
                        <div class="col-sm-9">
                            <input type="number" min="1" max="100" class="form-control" id="age" name="age" data-ng-model="age" placeholder="Enter Age" readonly required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="community" class="control-label col-sm-3">Community: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="community" name="community" placeholder="Enter Community" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="fname" class="control-label col-sm-3">Father Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Father Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mname" class="control-label col-sm-3">Mother Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="mname" name="mname" placeholder="Enter Mother Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gname" class="control-label col-sm-3">Guardian Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="gname" name="gname" placeholder="Enter Guardian Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address" class="control-label col-sm-3">Address: </label>
                        <div class="col-sm-9">
                            <textarea class="form-control" id="address" name="address" rows="5" placeholder="Enter Address" required></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="taluk" class="control-label col-sm-3">Taluk Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="taluk" name="taluk" placeholder="Enter Taluk Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pincode" class="control-label col-sm-3">Pincode: </label>
                        <div class="col-sm-9">
                            <input type="number" min="600001" max="699999" data-ng-minlength="6" data-ng-maxlength="6" data-ng-model="pincode" data-ng-required="true" class="form-control" id="pincode" name="pincode" placeholder="Enter Pincode" />
                            <span class="text-danger" data-ng-show="((registration.pincode.$error.minlength || registration.pincode.$error.maxlength || registration.pincode.$error.min || registration.pincode.$error.max) && registration.pincode.$dirty)">Invalid Pincode</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mobile" class="control-label col-sm-3">Mobile No: </label>
                        <div class="col-sm-9">
                            <input type="number" min="1111111111" max="9999999999" data-ng-minlength="10" data-ng-maxlength="10" class="form-control" id="mobile" name="mobile" data-ng-model="mobile" data-ng-required="true" placeholder="Enter 10 Digit Mobile No" />
                            <span class="text-danger" data-ng-show="((registration.mobile.$error.minlength || registration.mobile.$error.maxlength) && registration.mobile.$dirty)">Invalid Mobile No</span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="voterid" class="control-label col-sm-3">Voter ID: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="voterid" name="voterid" placeholder="Enter Voter ID" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="aadhar" class="control-label col-sm-3">Aadhar No: </label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="aadhar" name="aadhar" placeholder="Enter Aadhar No" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ration" class="control-label col-sm-3">Ration Card No: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ration" name="ration" placeholder="Enter Ration Card No" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="disability" class="control-label col-sm-3">Type Of Disability: </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="disability" name="disability" required>
                                <option value="">Select Disability</option>
                                <option value="Autism">Autism</option>
                                <option value="M.R">M.R</option>
                                <option value="CP">CP</option>
                                <option value="MD">MD</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="disability-percent" class="control-label col-sm-3">Disability %: </label>
                        <div class="col-sm-7">
                            <input type="range" class="form-control" id="disability-percent" name="disability-percent" min="45" max="100" step="5" value="45" />
                        </div>
                        <div class="col-sm-2">
                            <p id="percent-text" class="text-muted"><span id="percent"></span> %</p>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sswid" class="control-label col-sm-3">Social Security Welfare ID: </label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="sswid" name="sswid" placeholder="Enter Social Security Welfare ID" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="bank" class="control-label col-sm-3">Bank Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="bank" name="bank" placeholder="Enter Bank Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="branch" class="control-label col-sm-3">Branch Name: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="branch" name="branch" placeholder="Enter Branch Name" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="account" class="control-label col-sm-3">Account No: </label>
                        <div class="col-sm-9">
                            <input type="number" min="0" class="form-control" id="account" name="account" placeholder="Enter Account No" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="micr" class="control-label col-sm-3">MICR No: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="micr" name="micr" placeholder="Enter MICR No" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ifsc" class="control-label col-sm-3">IFSC No: </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="ifsc" name="ifsc" placeholder="Enter IFSC No" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pphoto" class="control-label col-sm-3">Person Photo: </label>
                        <div class="col-sm-9">
                            <div class="input-group">
                                <span class="input-group-btn">
                                    <span class="btn btn-info btn-file">
                                        Browse <input type="file" id="pphoto" name="pphoto" accept="image/*" required />
                                    </span>
                                </span>
                                <input type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="gcno" class="control-label col-sm-3">Guardianship Certificate No: </label>
                        <div class="col-sm-3">
                            <input type="text" class="form-control" id="gcno" name="gcno" placeholder="Enter Guardianship Certificate No" />
                        </div>
                        <label for="gcdate" class="control-label col-sm-3">Guardianship Certificate Date: </label>
                        <div class="col-sm-3">
                            <input type="date" class="form-control" id="gcdate" name="gcdate" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="status" class="control-label col-sm-3">Status: </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="Alive">Alive</option>
                                <option value="Dead">Dead</option>
                                <option value="Moved To Another District">Moved To Another District</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group"> 
                        <div class="col-sm-offset-3 col-sm-9">
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
                <hr>
            </div>
            <div id="list" data-ng-hide="listFlag">
                <h2 class="text-center">Registered Users</h2>
                <hr>
                <div class="form-group">
                    <label for="filter" class="control-label">Filter By National ID Card No</label>    
                    <input type="text" id="filter" data-ng-model="filterID" />
                    <button class="btn btn-info pull-right" ng-csv="users" csv-header="getHeader()" filename="ddawo_users.csv" field-separator="," decimal-separator=".">Download All</button>
                </div>
                <table  class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>National ID Card No</th><th>Name</th><th>Age</th><th>Address</th><th>Taluk Name</th><th>Pincode</th><th>Mobile No</th><th>Type Of Disability</th><th>Disability %</th><th>Photo</th><th>Status</th>
                        </tr>
                    </thead>
                        <tr dir-paginate="user in users | filter: filterID | itemsPerPage:30">
                            <td>{{ user.national_id }}</td><td>{{ user.name }}</td><td>{{ user.age }}</td><td>{{ user.address }}</td><td>{{ user.taluk_name }}</td><td>{{ user.pincode }}</td><td>{{ user.contact_no }}</td><td>{{ user.disability_type }}</td><td>{{ user.disability_percent }}</td><td><img data-ng-src="{{ user.photo }}" alt="Person Photo"></img></td><td>{{ user.status }}</td>
                        </tr>
                        <tr>
                            <td class="text-center" colspan="11"><dir-pagination-controls max-size="30" direction-links="true" boundary-links="true" ></dir-pagination-controls></td>
                        </tr>
                </table>
                <hr>
            </div>
            <div id="view" data-ng-hide="viewFlag">
                <h2 class="text-center">View User Info</h2>
                <hr>
                <form class="form-inline" role="form">
                    <div class="form-group">
                        <label for="user" class="control-label">Enter National ID Card No</label>
                        <input type="number" min="0" class="form-control" id="user" data-ng-model="userID" name="nationalid" placeholder="Enter National ID Card No" required />
                        <button class="btn btn-info" data-ng-click="getUserInfo()">View Info</button>
                    </div>
                </form>
                <br />
                <span class="text-center text-danger col-sm-12" data-ng-show="noUserFlag"><b>Not Found!</b></span>
                <table id="userData" class="table table-bordered table-hover" data-ng-show="userInfoFlag">
                    <thead>
                        <tr>
                            <td>Heading</td><td>Information</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="2" class="text-center"><img id="user-photo" data-ng-src="{{ user[0].photo }}" alt="User Photo"></img></td>
                        </tr>
                        <tr>
                            <td>National ID Card No</td><td>{{ user[0].national_id }}</td>
                        </tr>
                        <tr>
                            <td>Name</td><td>{{ user[0].name }}</td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td><td>{{ user[0].dob }}</td>
                        </tr>
                        <tr>
                            <td>Age</td><td>{{ user[0].age }}</td>
                        </tr>
                        <tr>
                            <td>Community</td><td>{{ user[0].community }}</td>
                        </tr>
                        <tr>
                            <td>Father Name</td><td>{{ user[0].father_name }}</td>
                        </tr>
                        <tr>
                            <td>Mother Name</td><td>{{ user[0].mother_name }}</td>
                        </tr>
                        <tr>
                            <td>Guardian Name</td><td>{{ user[0].guardian_name }}</td>
                        </tr>
                        <tr>
                            <td>Address</td><td>{{ user[0].address }}</td>
                        </tr>
                        <tr>
                            <td>Taluk Name</td><td>{{ user[0].taluk_name }}</td>
                        </tr>
                        <tr>
                            <td>Pincode</td><td>{{ user[0].pincode }}</td>
                        </tr>
                        <tr>
                            <td>Mobile No</td><td>{{ user[0].contact_no }}</td>
                        </tr>
                        <tr>
                            <td>Voter ID</td><td>{{ user[0].voter_id }}</td>
                        </tr>
                        <tr>
                            <td>Aadhar No</td><td>{{ user[0].aadhar_no }}</td>
                        </tr>
                        <tr>
                            <td>Ration Card No</td><td>{{ user[0].ration_card_no }}</td>
                        </tr>
                        <tr>
                            <td>Type Of Disability</td><td>{{ user[0].disability_type }}</td>
                        </tr>
                        <tr>
                            <td>Disability %</td><td>{{ user[0].disability_percent }}</td>
                        </tr>
                        <tr>
                            <td>Social Security Welfare ID</td><td>{{ user[0].social_security_welfare_id }}</td>
                        </tr>
                        <tr>
                            <td>Bank Name</td><td>{{ user[0].bank_name }}</td>
                        </tr>
                        <tr>
                            <td>Branch Name</td><td>{{ user[0].branch_name }}</td>
                        </tr>
                        <tr>
                            <td>Account No</td><td>{{ user[0].account_no }}</td>
                        </tr>
                        <tr>
                            <td>MICR No</td><td>{{ user[0].micr_no }}</td>
                        </tr>
                        <tr>
                            <td>IFSC No</td><td>{{ user[0].ifsc_code }}</td>
                        </tr>
                        <tr>
                            <td>Guardianship Certificate No</td><td>{{ user[0].guardian_certificate_no }}</td>
                        </tr>
                        <tr>
                            <td>Guardianship Certificate Date</td><td>{{ user[0].guardian_certificate_date }}</td>
                        </tr>
                        <tr>
                            <td>Status</td><td>{{ user[0].status }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center"><button class="btn btn-info" id="print">Print</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="js/main.min.js"></script>
    </body>
</html>