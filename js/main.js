var app = angular.module("ddawoApp", ["ngSanitize", "ngCsv", "angularUtils.directives.dirPagination"]);
app.controller("ddawoCtrl",["$scope", "$http", function($scope, $http) {
    var percent = jQuery("#percent-text");
    jQuery("#form-menu").addClass("active");
    percent.hide();
    $scope.listFlag = true;
    $scope.viewFlag = true;
    $scope.formFlag = false;
    
    jQuery('#disability-percent').on("mouseenter change", function() {
        jQuery("#percent").html(jQuery(this).val());
        percent.show("2000").hide("2000");
    });
    
    jQuery('#print').on("click", function() {
        print();
    });
    
    $scope.getAge = function() {
        var today = new Date();
        var birthDate = new Date($scope.dob);
        var age = today.getFullYear() - birthDate.getFullYear();
        var m = today.getMonth() - birthDate.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
        $scope.age = age;
    }
    
    $scope.getHeader = function() {
        return ["National ID Card No", "Name", "Date Of Birth", "Age", "Community", "Father Name", "Mother Name", "Guardian Name",
                "Address", "Taluk Name", "Pincode", "Mobile No", "Voter ID", "Aadhar No", "Ration Card No", "Type Of Disability",
                "Disability %", "Social Security Welfare ID", "Bank Name", "Branch Name", "Account No", "MICR No", "IFSC No",
                "Guardianship Certificate No", "Guardianship Certificate Date", "Status", "Person Photo"];
    }
    
    $scope.print = function() {
        var divToPrint = jQuery("#userData");
        newWin = window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();
    }
    
    $scope.form = function() {
        jQuery("#list-menu,#view-menu").removeClass("active");
        jQuery("#form-menu").addClass("active");
        $scope.listFlag = true;
        $scope.viewFlag = true;
        $scope.formFlag = false;
    }
    
    $scope.list = function() {
        jQuery("#form-menu,#view-menu").removeClass("active");
        jQuery("#list-menu").addClass("active");
        $scope.formFlag = true;
        $scope.viewFlag = true;
        $scope.filterID = "";
        $http({method: 'GET', url: 'script/get_users.php' })
        .then(function(response) {
            if (response.data.length != 0) {
                $scope.users = response.data;
            }
        }, function(response) {
            console.log("Failed to get data!");
        });
        $scope.listFlag = false;
    }
    
    $scope.view = function() {
        $scope.userID = "";
        $scope.noUserFlag = false;
        $scope.userInfoFlag = false;
        jQuery("#form-menu,#list-menu").removeClass("active");
        jQuery("#view-menu").addClass("active");
        $scope.formFlag = true;
        $scope.listFlag = true;
        $scope.viewFlag = false;
    }
    
    $scope.getUserInfo = function() {
        if($scope.userID !== undefined) {
            $http({method: 'POST', url: 'script/get_user.php', data: { id: $scope.userID }})
            .then(function(response) {
                if(response.data.length != 0) {
                    $scope.user = response.data;
                    $scope.userInfoFlag = true;
                    $scope.noUserFlag = false;
                } else {
                    $scope.userInfoFlag = false;
                    $scope.noUserFlag = true;
                }
            }, function(response) {
                console.log("Failed to get data!");
            });
        }
    }
}]);