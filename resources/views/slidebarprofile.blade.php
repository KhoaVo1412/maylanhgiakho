
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('app/css/admin/main.css')}}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" type="image/png" href="{{ asset('app/images/logoDulich.ico') }}">

    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet"
        href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css') }}"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Thông tin</title>
    <style type="text/css">
    .admin-button-list{
    /* line-height: 9rem; */
    padding: 1.5rem 0
}

.admin-button-list .cl-btn{
    margin-bottom: 1.5rem;
}
#title-data {
    font-size: 2rem;
    margin-top: 2rem;
    font-family: -webkit-body;
}

#title-data i {
    margin: auto 1rem;
    color: black;
}

.admin-button-list div button{
border: none;
font-size: 1.8rem;
background: none;
color: #344767;
}
.admin-button-list .cl-btn .table{
line-height: 3;
font-size: 1.7rem;
margin-top: -1rem;
padding-left: 3rem;
}

.admin-button-list .cl-btn .table a {
text-decoration: none;
color: darkgreen;
}

#title-imglog {
    font-size: 1.6rem;
    display: flex;
    align-items: center;
    color: black;
    font-family: -webkit-body;

    padding-right: 1rem;
    padding-left: 1rem;
}

.admim-header{
width: 18%;
/* padding-left: 3rem; */
height: fit-content;
/* border-right: solid 2px #D3D3D3; */
/* border-left: solid 2px #D3D3D3; */
/* border-bottom: solid 2px #D3D3D3; */
/* border-top: solid 2px #D3D3D3; */
}

.admin-app{
border-bottom: solid 2px #D3D3D3;

}

#body-admin {
background-color: #f8f9fa !important;
font-family: tahoma;
}

.admin-button-list .cl-btn button i {
box-shadow: 0px 0px 10px 1px #dcdcdc;
padding: 1rem;
border-radius: 12px;
color: blue;
}

#btn-table{
display: block;
border-radius: 5px;
margin: 0px 17px 0 26px;
box-shadow: inset 0px 0px 31px -36px;
margin-bottom: 3rem;
}

/* table */

.create a{
text-decoration: none;
color: navy;
font-weight: bold;
}

.create{
text-align: center;
width: 14.5rem;
border-radius: 7px;
background: red;
border: none;
box-shadow: 0px 0px 25px -3px;
padding: 20px;


margin-left: 73.5rem;
margin-top: 10rem;
margin-bottom: 4rem;
}

table, th, td {
border: 1px solid white;
border-collapse: collapse;
}
th, td {
background-color: #d3d3d338;
}

.table-main-right{
margin: auto 7rem;
font-size: 1.4rem;
}

.table-main-right .title-admin-table th {
    padding: 1rem;
    background-color: black;
    color: white;
}

.content-admin-table th {
    font-size: 1.4rem;
    font-weight: 100;
    height: 11rem;
}

.content-admin-table th i {
    font-size: 2rem;
    padding: 13px;
}

.content-admin-table button {
    border: none;
    background: none;
}

.xem-chi-tiet {
    text-decoration: none;
    text-shadow: 2px 2px 8px #FF0000;
}
a:hover{
    color: red;
}

a{
    text-decoration: none;
    color: black;
    font-size: 20px;
    font-family: bold;

}
    </style>
</head>

<body id="body-admin">

    <div style="display: flex; margin-top: 135px">
        <header class="admim-header">
            <div class="admin-app">
               <div style="display: flex; justify-content: center; padding: 18px 0 0 0; background: white">
                    <div><img style="width:4rem" src="{{asset('img/team-1.jpg')}}" alt=""></div>
                    <div id="title-imglog"><b>Thông Tin <br> </b></div>
               </div>
            </div>
            <div class="admin-button-list">
                <div class="cl-btn">
                    <i class="fas fa-user" style="font-size:20px"></i> <a href="{{ route('profile') }}"> Thông Tin Tài Khoản </a> <br>
                </div>

                <div class="cl-btn">
                    <i class="fas fa-history" style="font-size:20px"></i> <a href="{{route('history_order') }}"> Lịch Sử Đặt Hàng </a> <br>
                </div>
            </div>
        </header>

        <main style="width:80%">

            @yield('main-admin')

        </main>

        {{-- @include('') --}}

    </div>

</body>

<script src="{{ asset("app/js/display/admin/main.js") }}"></script>

</html>