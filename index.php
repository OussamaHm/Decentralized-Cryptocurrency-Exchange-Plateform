<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>EMSI Project - Cryptocurrency Dashboard Admin Template</title>
    <!-- Custom CSS -->
          <link href="css/style.css" rel="stylesheet">
</head>

<body class="header-fix fix-sidebar">
<?php
// Database connection parameters
$servername = "localhost"; // Change this if your MySQL server is on a different host
$username = "root"; // Change this to your MySQL username
$password = ""; // Change this to your MySQL password
$database = "crypto"; // Change this to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// Function to retrieve balance by token
function getBalance($conn, $token) {
    $token = $conn->real_escape_string($token); // Escape the token to prevent SQL injection
    $sql = "SELECT value FROM coin WHERE token = '$token'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['value'];
    } else {
        return "Token not found";
    }
}

// Get balance for BTC
if (isset($_GET['BTC']) && isset($_GET['USDT']) && isset($_GET['TRADE'])) {
    // Retrieve the values from the URL parameters
    $BTC = $_GET['BTC'];
    $USDT = $_GET['USDT'];
    $TRADE = $_GET['TRADE'];

if($TRADE==0){
    $sql = "INSERT INTO orders values('SELL',$BTC)";
    $result = $conn->query($sql);
updateBalance($conn, 'BTC', -$BTC);
updateBalance($conn, 'USDT', (($BTC)*61507) );
}
else if ($TRADE==1) {
    $sql = "INSERT INTO orders values('BUY',(($USDT)*0.00001625))";
    $result = $conn->query($sql);
    updateBalance($conn, 'BTC', (($USDT)*0.00001625));
updateBalance($conn, 'USDT', -$USDT );
}
} else {

}
$BTC_balance = getBalance($conn, 'BTC');
echo "BTC Balance: " . $BTC_balance . "<br>";

// Get balance for USDT
$USDT_balance = getBalance($conn, 'USDT');
echo "USDT Balance: " . $USDT_balance . "<br>";

// Function to update balance by token
function updateBalance($conn, $token, $amount) {
    $token = $conn->real_escape_string($token); // Escape the token to prevent SQL injection
    $amount = floatval($amount); // Convert amount to integer
    $sql = "UPDATE coin SET value = value + $amount WHERE token = '$token'";
    if ($conn->query($sql) === TRUE) {
        echo ".              Balance updated successfully for $token";
    } else {
        echo "Error updating balance: " . $conn->error;
    }
}

function fetch_array_orders($conn){
    $sql = "SELECT * FROM orders";
    $result = $conn->query($sql);

$ordersArray = array();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch rows and store in the array
        while ($row = $result->fetch_assoc()) {
            $ordersArray[] = array(
                'Type' => $row['Type'],
                'amount' => $row['Amount']
            );
        }
        $reversedArray = array_reverse($ordersArray);

        // Loop through the reversed array
        $count = 0;
        foreach ($reversedArray as $order) {
            if( $count == 6){
                break;
            }
            echo " <tr>
            <td>2024-05-09</td>"."
            <td class=\"success\">".$order['Type']."</td>
            <td><i class=\"cc BTC\"></i>".$order['amount']."</td>
           
            <td>61507 USD</td>
            <td>".($order['amount'] * 61507)."</td>
            <td>0.2</td>
            <td>
                <button class=\"btn btn-sm round btn-outline-danger\"> Cancel</button>
            </td>
        </tr>";
            $count ++; 

        }
    } else {
        echo "0 results";
    }


}



function fetch_array_Sell($conn){
    $sql = "SELECT * FROM orders where Type = 'SELL'" ;
    $result = $conn->query($sql);

$ordersArray = array();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch rows and store in the array
        while ($row = $result->fetch_assoc()) {
            $ordersArray[] = array(
                'Type' => $row['Type'],
                'amount' => $row['Amount']
            );
        }
        $reversedArray = array_reverse($ordersArray);

        // Loop through the reversed array
        $count = 0;
        foreach ($reversedArray as $order) {
            if( $count == 6){
                break;
            }
            echo "
            <tr>
                                                <td>61507 USD</td>
                                                <td><i class=\"cc BTC\"></i>".$order['amount']."</td>
                                                <td>".($order['amount'] * 61507)." USD</td>
                                            </tr>
            ";
            $count ++; 

        }
    } else {
        echo "0 results";
    }


}


function fetch_array_Buy($conn){
    $sql = "SELECT * FROM orders where Type = 'BUY'" ;
    $result = $conn->query($sql);

$ordersArray = array();

    // Check if there are results
    if ($result->num_rows > 0) {
        // Fetch rows and store in the array
        while ($row = $result->fetch_assoc()) {
            $ordersArray[] = array(
                'Type' => $row['Type'],
                'amount' => $row['Amount']
            );
        }
        $reversedArray = array_reverse($ordersArray);

        // Loop through the reversed array
        $count = 0;
        foreach ($reversedArray as $order) {
            if( $count == 6){
                break;
            }
            echo "
            <tr>
                                                <td>61507 USD</td>
                                                <td><i class=\"cc BTC\"></i>".$order['amount']."</td>
                                                <td>".($order['amount'] * 61507)." USD</td>
                                            </tr>
            ";
            $count ++; 

        }
    } else {
        echo "0 results";
    }


}

?>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <!-- header header  -->
        <div class="header">
                             <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <!-- Logo -->
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.html">
                        <!-- Logo icon -->
                        <b><img src="images/logo.png" alt="homepage" class="dark-logo" /></b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span><img src="images/logo-text.png" alt="homepage" class="dark-logo" /></span>
                    </a>
                </div>
                <!-- End Logo -->
                <div class="navbar-collapse">
                    <!-- toggle and nav items -->
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <!-- This is  -->
                        <li class="nav-item"> <a class="nav-link toggle-nav hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggle hidden-sm-down text-muted  " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                        <!-- Messages -->
                        <li class="nav-item dropdown mega-menu"> <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="ti-wallet m-r-5"></i> Wallet</a>
                            <div class="dropdown-menu animated slideInDown">
                                <ul class="mega-menu-menu row">
                                    <li class="col-lg-3  m-b-30">
                                        <h4 class="m-b-20">Bitcoin BTC</h4>
                                        <!-- Contact -->
                                        <ul class="list-style-none">
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                        </ul>
                                    </li>
                                    <li class="col-lg-3 col-xlg-3 m-b-30">
                                        <h4 class="m-b-20">Bitcoin BTC</h4>
                                        <!-- List style -->
                                        <ul class="list-style-none">
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                        </ul>
                                    </li>
                                    <li class="col-lg-3 col-xlg-3 m-b-30">
                                        <h4 class="m-b-20">Bitcoin BTC</h4>
                                        <!-- List style -->
                                        <ul class="list-style-none">
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                        </ul>
                                    </li>
                                    <li class="col-lg-3 col-xlg-3 m-b-30">
                                        <h4 class="m-b-20">Bitcoin BTC</h4>
                                        <!-- List style -->
                                        <ul class="list-style-none">
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                            <li><a href="#"><i class="cc BTC"></i> Bitcoin Transaction</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Messages -->
                    </ul>
                    <!-- User profile and search -->
                    <ul class="navbar-nav my-lg-0">
                        <!-- Comment -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated slideInRight">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="header-notify">
                                            <!-- Message -->
                                            <a href="#">
                                                <i class="cc BTC m-r-10 f-s-40" title="BTC"></i>
                                                
                                                <div class="notification-contnet">
                                                    <h5>All Transaction BTC</h5> <span class="mail-desc">Just see the my new admin!</span> 
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <i class="cc LTC m-r-10 f-s-40" title="BTC"></i>
                                                <div class="notification-contnet">
                                                    <h5>This is LTC coin</h5> <span class="mail-desc">Just a reminder that you have event</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <i class="cc DASH m-r-10 f-s-40" title="BTC"></i>
                                                <div class="notification-contnet">
                                                    <h5>This is DASH coin</h5> <span class="mail-desc">You can customize this template as you want</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <i class="cc XRP m-r-10 f-s-40" title="BTC"></i>
                                                <div class="notification-contnet">
                                                    <h5>This is LTC coin</h5> <span class="mail-desc">Just see the my admin!</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> Check all notifications <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Comment -->
                        <!-- Messages -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated slideInRight" aria-labelledby="2">
                                <ul>
                                    <li>
                                        <div class="drop-title">You have 4 new messages</div>
                                    </li>
                                    <li>
                                        <div class="header-notify">
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="notification-contnet">
                                                    <h5>Michael Qin</h5> <span class="mail-desc">Just see the my admin!</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="notification-contnet">
                                                    <h5>John Doe</h5> <span class="mail-desc">I've sung a song! See you at</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="notification-contnet">
                                                    <h5>Mr. John</h5> <span class="mail-desc">I am a singer!</span>
                                                </div>
                                            </a>
                                            <!-- Message -->
                                            <a href="#">
                                                <div class="notification-contnet">
                                                    <h5>Michael Qin</h5> <span class="mail-desc">Just see the my admin!</span>
                                                </div>
                                            </a>
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> See all e-Mails <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Messages -->
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i></a>
                            <div class="dropdown-menu dropdown-menu-right animated slideInRight">
                                <ul class="dropdown-user">
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"> Profile</a></li>
                                    <li><a href="#"> Balance</a></li>
                                    <li><a href="#"> Inbox</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="#"> Setting</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="http://localhost/CryptoCurrencyExchange/login.php"> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <!-- End header header -->
        <!-- Left Sidebar  -->
        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebar-menu">
                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-tachometer"></i><span class="hide-menu">Dashboard <span class="label label-rouded label-primary pull-right">1</span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="index.html">Dashboard 1 </a></li>
                            </ul>
                        </li>
                        <li class="nav-label">Layout</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-columns"></i><span class="hide-menu">Layout</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="layout-blank.html">Blank</a></li>
                                <li><a href="layout-boxed.html">Boxed</a></li>
                                <li><a href="layout-fix-header.html">Fix Header</a></li>
                                <li><a href="layout-fix-sidebar.html">Fix Sidebar</a></li>
                            </ul>
                        </li>
                        <li class="nav-label">Apps &amp; Charts</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope"></i><span class="hide-menu">Mailbox</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="email-compose.html">Compose</a></li>
                                <li><a href="email-read.html">Read</a></li>
                                <li><a href="email-inbox.html">Inbox</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Charts</span></a>
                            <ul aria-expanded="false" class="collapse">
                                
                                <li><a href="chart-morris.html">Morris</a></li>
                                <li><a href="chart-chartjs.html">ChartJs</a></li>
                                <li><a href="chart-chartist.html">Chartist </a></li>
                                <li><a href="chart-amchart.html">AmChart</a></li>
                                <li><a href="chart-echart.html">EChart</a></li>
                                <li><a href="chart-sparkline.html">Sparkline</a></li>
                                <li><a href="chart-peity.html">Peity</a></li>
                            </ul>
                        </li>
                        <li class="nav-label">Features</li>
                   
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Data</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="form-basic.html">Basic Forms</a></li>
                                <li><a href="form-layout.html">Form Layout</a></li>
                                <li><a href="form-validation.html">Form Validation</a></li>
                                <li><a href="form-editor.html">Editor</a></li>
                                <li><a href="form-dropzone.html">Dropzone</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-table"></i><span class="hide-menu">Tables</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="table-bootstrap.html">Basic Tables</a></li>
                                <li><a href="table-datatable.html">Data Tables</a></li>
                            </ul>
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="ti-wallet m-r-5"></i><span class="hide-menu">Wallet</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="widget.html">Wallet</a></li>
                            </ul>
                        </li>
                       
              
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>
        <!-- End Left Sidebar  -->
        <!-- Page wrapper  -->
        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->
                <div class="row">
                    <div class="col-12">
                        <div class="crypto-ticker m-b-15">
                            <ul id="webticker-dark-icons">
                                <li data-update="item1"><i class="cc BTC"></i> BTC <span class="coin-value"> $11.039232</span></li>
                                <li data-update="item2"><i class="cc ETH"></i> ETH <span class="coin-value"> $1.2792</span></li>
                                <li data-update="item3"><i class="cc GAME"></i> GAME <span class="coin-value"> $11.039232</span></li>
                                <li data-update="item4"><i class="cc LBC"></i> LBC <span class="coin-value"> $0.588418</span></li>
                                <li data-update="item5"><i class="cc NEO"></i> NEO <span class="coin-value"> $161.511</span></li>
                                <li data-update="item6"><i class="cc STEEM"></i> STE <span class="coin-value"> $0.551955</span></li>
                                <li data-update="item7"><i class="cc LTC"></i> LIT <span class="coin-value"> $177.80</span></li>
                                <li data-update="item8"><i class="cc NOTE"></i> NOTE <span class="coin-value"> $13.399</span></li>
                                <li data-update="item9"><i class="cc MINT"></i> MINT <span class="coin-value"> $0.880694</span></li>
                                <li data-update="item10"><i class="cc IOTA"></i> IOT <span class="coin-value"> $2.555</span></li>
                                <li data-update="item11"><i class="cc DASH"></i> DAS <span class="coin-value"> $769.22</span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-seven">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc BTC" title="BTC"></i>
                                        </div>
                                        <div class="col-5">
                                            <h3>Bitcoin BTC</h3>
                                            <h6 class="text-muted">0.00000434 <span class="color-gray">BTC</span> <span class="text-info">$0.04</span></h6>

                                        </div>
                                        <div class="col-5 text-right">
                                            <h3>$61,569</h3>
                                            <h6 class="text-success">9% <i class="ti-arrow-up f-s-16 text-success m-l-5"></i></h6>
                                        </div>
                                    </div>
                                    <div class="m-t-15">
                                        <span class="peity-btc" data-peity='{ "fill": "rgba(247, 147, 26, 0.5)", "stroke": "#f7931a"}'>6,2,8,4,3,8,1,3,6,5,9,2,8,1,4,8,9,8,2,1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-seven">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc LTC" title="LTC"></i>
                                        </div>
                                        <div class="col-5">
                                            <h3>Litecoin LTC</h3>
                                            <h6 class="text-muted">0.00000434 <span class="color-gray">BTC</span> <span class="text-info">$0.04</span></h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h3>$86</h3>
                                            <h6 class="text-danger">13% <i class="ti-arrow-down f-s-16 text-danger m-l-5"></i></h6>
                                        </div>
                                    </div>
                                    <div class="m-t-15">
                                        <span class="peity-ltc" data-peity='{ "fill": "rgba(131, 131, 131, 0.59)", "stroke": "#838383"}'>6,2,8,4,3,8,1,3,6,5,9,2,8,1,4,8,9,8,2,1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-seven">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc NEO" title="NEO"></i>
                                        </div>
                                        <div class="col-5">
                                            <h3>Neo NEO</h3>
                                            <h6 class="text-muted">0.00000434 <span class="color-gray">BTC</span> <span class="text-info">$0.04</span></h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h3>$569</h3>
                                            <h6 class="text-warning">1% <i class="ti-arrow-up f-s-16 text-warning m-l-5"></i></h6>
                                        </div>
                                    </div>
                                    <div class="m-t-15">
                                        <span class="peity-neo" data-peity='{ "fill": "rgba(88, 191, 0, 0.59)", "stroke": "#58bf00"}'>6,2,8,4,3,8,1,3,6,5,9,2,8,1,4,8,9,8,2,1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-seven">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc DASH"></i>
                                        </div>
                                        <div class="col-5">
                                            <h3>Dash DASH</h3>
                                            <h6 class="text-muted">0.00000434 <span class="color-gray">BTC</span> <span class="text-info">$0.04</span></h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h3>$421</h3>
                                            <h6 class="text-primary">6% <i class="ti-arrow-up f-s-16 text-primary m-l-5"></i></h6>
                                        </div>
                                    </div>
                                    <div class="m-t-15">
                                        <span class="peity-dash" data-peity='{ "fill": "rgba(28, 117, 188, 0.45)", "stroke": "#1c75bc"}'>6,2,8,4,3,8,1,3,6,5,9,2,8,1,4,8,9,8,2,1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-seven">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc ETH" title="ETH"></i>
                                        </div>
                                        <div class="col-5">
                                            <h3>Ethereum  ETH</h3>
                                            <h6 class="text-muted">0.00000434 <span class="color-gray">BTC</span> <span class="text-info">$0.04</span></h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h3>$3,569</h3>
                                            <h6 class="text-info">12% <i class="ti-arrow-up f-s-16 text-info m-l-5"></i></h6>
                                        </div>
                                    </div>
                                    <div class="m-t-15">
                                        <span class="peity-eth" data-peity='{ "fill": "rgba(70, 70, 70, 0.5)", "stroke": "#282828"}'>6,2,8,4,3,8,1,3,6,5,9,2,8,1,4,8,9,8,2,1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="stat-widget-seven">
                                    <div class="row">
                                        <div class="col-2">
                                            <i class="cc XRP" title="XRP"></i>
                                        </div>
                                        <div class="col-5">
                                            <h3>Ripple  XRP</h3>
                                            <h6 class="text-muted">0.00000434 <span class="color-gray">BTC</span> <span class="text-info">$0.04</span></h6>
                                        </div>
                                        <div class="col-5 text-right">
                                            <h3>$0.7</h3>
                                            <h6 class="text-danger">17% <i class="ti-arrow-up f-s-16 text-danger m-l-5"></i></h6>
                                        </div>
                                    </div>
                                    <div class="m-t-15">
                                        <span class="peity-xrp" data-peity='{ "fill": "rgba(52, 106, 169, 0.51)", "stroke": "#346aa9"}'>6,2,8,4,3,8,1,3,6,5,9,2,8,1,4,8,9,8,2,1</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /# row -->
                <div class="row">
                    <div class="col-lg-5">
                        <div id="accordion" class="accordion">
                            <div class="card">
                                <a class="card-header bg-primary-darken-5 card-title" data-toggle="collapse" aria-expanded="true" href="#collapseOne">
                                    Limit
                                </a>
                                <div id="collapseOne" class="card-body collapse show" data-parent="#accordion">
                                    <div class="row">
                                        <div class="col-12 col-xl-6">
                                            <div class="row my-2 p-l-15 p-r-15">
                                                <div class="col-4">
                                                    <h5 class="text-bold-600 mb-0">Buy BTC</h5>
                                                </div>
                                                <div class="col-8 text-right">
                                                    <p class="text-muted mb-0">USDT Balance: <?php echo $USDT_balance; ?></p>
                                         
                                                </div>
                                            </div>
                                            <form id="buyBTCForm" class="form form-horizontal" action="http://localhost/CryptoCurrencyExchange/index.php" method="GET">
        <div class="form-body">
            <div class="form-group row">
                <label class="col-md-4 col-form-label" for="btc-limit-buy-amount">Amount</label>
                <div class="col-md-8">
                    <input type="text" id="btc-limit-buy-amount" class="form-control" placeholder="6026 USDT" name="btc-limit-buy-amount" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label" for="btc-limit-buy-price"></label>
                <div class="col-md-8">
                    <b>Market Price: 61507 USDT</b>
                </div>
            </div>
            <div class="form-actions pb-0 m-l-15 m-r-15">
                
                <button type="submit" class="btn round btn-success btn-block btn-glow">Buy BTC</button>
            </div>
        </div>
    </form>

    <script>
        document.getElementById("buyBTCForm").addEventListener("submit", function(event) {
            // Prevent the default form submission
            event.preventDefault();
            
            // Get the value entered in the "Amount" field
            var amount = document.getElementById("btc-limit-buy-amount").value;
            
            // Construct the URL with the updated USDT value
            var url = "http://localhost/CryptoCurrencyExchange/index.php?BTC=0&USDT=" + amount + "&TRADE=1";
            
            // Redirect the user to the constructed URL
            window.location.href = url;
        });
    </script>
                                        </div>
                                        <div class="col-12 col-xl-6">
                                            <div class="row my-2 p-r-15 p-l-15">
                                                <div class="col-4">
                                                    <h5 class="text-bold-600 mb-0">Sell BTC</h5>
                                                </div>
                                                <div class="col-8 text-right">
                                                    <p class="text-muted mb-0">BTC Balance: <?php echo $BTC_balance; ?> </p>
                                                </div>
                                            </div>
                                            <form id="sellBTCForm" class="form form-horizontal" action="http://localhost/CryptoCurrencyExchange/index.php" method="GET">
        <div class="form-body">
            <div class="form-group row">
                <label class="col-md-4 col-form-label" for="btc-limit-sell-amount">Amount</label>
                <div class="col-md-8">
                    <input type="text" id="btc-limit-sell-amount" class="form-control" placeholder="0.026547 BTC" name="btc-limit-sell-amount" required>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-4 col-form-label" for="btc-limit-sell-price"></label>
                <div class="col-md-8">
                    <b>Market Price: 16 kSat</b>
                </div>
            </div>
            <div class="form-actions pb-0 m-l-15 m-r-15">
                <button type="submit" class="btn round btn-danger btn-block btn-glow">Sell BTC</button>
            </div>
        </div>
    </form>

    <script>
        document.getElementById("sellBTCForm").addEventListener("submit", function(event) {
            // Prevent the default form submission
            event.preventDefault();
            
            // Get the value entered in the "Amount" field
            var amount = document.getElementById("btc-limit-sell-amount").value;
            
            // Construct the URL with the updated BTC value (amount), USDT set to 0, and TRADE set to 0
            var url = "http://localhost/CryptoCurrencyExchange/index.php?BTC=" + amount + "&USDT=0&TRADE=0";
            
            // Redirect the user to the constructed URL
            window.location.href = url;
        });
    </script>
                                                      
                                        </div>
                                    </div>
                                </div>

                                
                                <a class="card-header collapsed bg-primary-darken-5 card-title" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                    Market 
                                </a>
                                <div id="collapseTwo" class="card-body collapse" data-parent="#accordion">
                                    <div class="row">
                                        <div class="col-12 col-xl-6">
                                            <div class="row my-2 p-l-15 p-r-15">
                                                <div class="col-4">
                                                    <h5 class="text-bold-600 mb-0">Buy BTC</h5>
                                                </div>
                                                <div class="col-8 text-right">
                                                    <p class="text-muted mb-0">USD Balance: $ 5000.00</p>
                                                </div>
                                            </div>
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-form-label" for="btc-market-buy-price">Price</label>
                                                        <div class="col-md-8">
                                                            <input type="number" disabled id="btc-market-buy-price" class="form-control" placeholder="Market prise $" name="btc-market-buy-price">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-form-label" for="btc-market-buy-amount">Amount</label>
                                                        <div class="col-md-8">
                                                            <input type="number" id="btc-market-buy-amount" class="form-control" placeholder="0.026547 BTC" name="btc-market-buy-amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-actions pb-0 m-l-15 m-r-15">
                                                        <button type="submit" class="btn round btn-success btn-block btn-glow"> Buy BTC </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <div class="col-12 col-xl-6">
                                            <div class="row my-2 p-r-15 p-l-15">
                                                <div class="col-4">
                                                    <h5 class="text-bold-600 mb-0">Sell BTC</h5>
                                                </div>
                                                <div class="col-8 text-right">
                                                    <p class="text-muted mb-0">BTC Balance: 1.2654898</p>
                                                </div>
                                            </div>
                                            <form class="form form-horizontal">
                                                <div class="form-body">
                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-form-label">Price</label>
                                                        <div class="col-md-8">
                                                            <input type="number" disabled id="btc-market-sell-price" class="form-control" placeholder="Market prise $" name="btc-market-sell-price">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-form-label" for="btc-market-sell-amount">Amount</label>
                                                        <div class="col-md-8">
                                                            <input type="number" id="btc-market-sell-amount" class="form-control" placeholder="0.026547 BTC" name="btc-market-sell-amount">
                                                        </div>
                                                    </div>
                                                    <div class="form-actions pb-0 m-l-15 m-r-15">
                                                        <button type="submit" class="btn round btn-danger btn-block btn-glow"> Sell BTC </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a class="card-header collapsed bg-primary-darken-5 card-title" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                                    Stop Limit 
                                </a>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 col-xl-6">
                                                <div class="row my-2 p-l-15 p-r-15">
                                                    <div class="col-4">
                                                        <h5 class="text-bold-600 mb-0">Buy BTC</h5>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <p class="text-muted mb-0">USD Balance: $ 5000.00</p>
                                                    </div>
                                                </div>
                                                <form class="form form-horizontal">
                                                    <div class="form-body">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-buy">Stop</label>
                                                            <div class="col-md-8">
                                                                <input type="number" id="btc-stop-buy" class="form-control" placeholder="$ 11916.9" name="btc-stop-buy">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-buy-limit">Limit</label>
                                                            <div class="col-md-8">
                                                                <input type="number" id="btc-stop-buy-limit" class="form-control" placeholder="$ 12000.0" name="btc-stop-buy-limit">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-buy-amount">Amount</label>
                                                            <div class="col-md-8">
                                                                <input type="number" id="btc-stop-buy-amount" class="form-control" placeholder="0.026547 BTC" name="btc-stop-buy-amount">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-buy-total">Total</label>
                                                            <div class="col-md-8">
                                                                <input type="number" disabled id="btc-stop-buy-total" class="form-control" placeholder="$ 318.1856" name="btc-stop-buy-total">
                                                            </div>
                                                        </div>
                                                        <div class="form-actions pb-0 m-l-15 m-r-15">
                                                            <button type="submit" class="btn round btn-success btn-block btn-glow"> Buy BTC </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="col-12 col-xl-6">
                                                <div class="row my-2 p-r-15 p-l-15">
                                                    <div class="col-4">
                                                        <h5 class="text-bold-600 mb-0">Sell BTC</h5>
                                                    </div>
                                                    <div class="col-8 text-right">
                                                        <p class="text-muted mb-0">BTC Balance: 1.2654898</p>
                                                    </div>
                                                </div>
                                                <form class="form form-horizontal">
                                                    <div class="form-body">
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-sell">Stop</label>
                                                            <div class="col-md-8">
                                                                <input type="number" id="btc-stop-sell" class="form-control" placeholder="$ 11916.9" name="btc-stop-sell">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-sell-limit">Limit</label>
                                                            <div class="col-md-8">
                                                                <input type="number" id="btc-stop-sell-limit" class="form-control" placeholder="$ 12000.0" name="btc-stop-sell-limit">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-sell-amount">Amount</label>
                                                            <div class="col-md-8">
                                                                <input type="number" id="btc-stop-sell-amount" class="form-control" placeholder="0.026547 BTC" name="btc-stop-sell-amount">
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-md-4 col-form-label" for="btc-stop-sell-total">Total</label>
                                                            <div class="col-md-8">
                                                                <input type="number" disabled id="btc-stop-sell-total" class="form-control" placeholder="$ 318.1856" name="btc-stop-sell-total">
                                                            </div>
                                                        </div>
                                                        <div class="form-actions pb-0 m-l-15 m-r-15">
                                                            <button type="submit" class="btn round btn-danger btn-block btn-glow"> Sell BTC </button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card">
                            <div class="card-title">
                                <h4>Active Order</h4></div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-de mb-0">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Amount BTC</th>
                                                
                                                <th>Price</th>
                                                <th>USD</th>
                                                <th>Fee (%)</th>
                                                <th>Cancel</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php fetch_array_orders($conn); ?>
                                            
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-title">
                                <h4>Sell Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-de mb-0">
                                        <thead>
                                            <tr>
                                                <th>Price per BTC</th>
                                                <th>BTC Ammount</th>
                                                <th>Total($)</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                           <?php fetch_array_Sell($conn);  ?>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-6">
                        <div class="card">
                            <div class="card-title">
                                <h4>Buy Order</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-de mb-0">
                                        <thead>
                                            <tr>
                                                <th>Price per BTC</th>
                                                <th>BTC Ammount</th>
                                                <th>Total($)</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        <?php fetch_array_Buy($conn);  ?>
                                           
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer"> © 2024 All Right Reserved.</footer>
            <!-- End footer -->
        </div>
        <!-- End Page wrapper  -->
    </div>
    <!-- End Wrapper -->
    <!-- All Jquery -->
    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/jquery.slimscroll.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--stickey kit -->
    <script src="js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <!--Custom JavaScript -->
    <script src="js/lib/webticker/jquery.webticker.min.js"></script>
    <script src="js/lib/peitychart/jquery.peity.min.js"></script>
    <!-- scripit init-->
    <script src="js/custom.min.js"></script>
    <script src="js/dashboard-1.js"></script>
</body>
<?php $conn->close();
?>

</html>