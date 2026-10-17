<!DOCTYPE html>
<html lang="en">
<head>
    @include('head')
    <title>Chi Tiết Đơn Hàng</title>
</head>

    <body >

        <!-- Header -->
        @include('header')
        {{-- <div class="customer mt-3" style="padding: 125px 0 0 0;">
        <ul>
            @foreach ( $cthd as $cthds)
            <li>Tên: <strong>{{ $cthds->name }}</strong></li>
            <li>SĐT: <strong>{{ $cthds->phone }}</strong></li>
            <li>Địa Chỉ: <strong>{{ $cthds->address }}</strong></li>
            <li>Email: <strong>{{ $cthds->email }}</strong></li>
            <li>Ghi Chú: <strong>{{ $cthds->content }}</strong></li>
            @endforeach
        </ul>
        </div> --}}

    <div class="carts" style="padding: 125px 0 0 0;">
        <h2 style="background: #3ead2a; color: white; height: 3rem; text-align: center; padding-top:5px">Chi Tiết Đơn Hàng</h2>
        @include('tabhistory')
        <table class="table">
            <tbody>
            <tr class="table_head">
                <th class="column-1">Hình</th>
                <th class="column-2">Tên SP</th>
                <th class="column-3">Giá</th>
                <th class="column-4">SL</th>
                <th class="column-5">Size</th>
                <th class="column-5">Màu</th>
                <th class="column-6">Thành tiền</th>
            </tr>

            @foreach($ctproducts as $key => $ctproduct)
                
                <tr>
                    <td class="column-1">
                        <div class="">
                        <a href="/san-pham/{{ $ctproduct->id }}-{{ Str::slug($ctproduct->name, '-') }}.html">    <img src="{{ $ctproduct->thumb }}" alt="IMG" style="width: 100px"></a>
                        </div>
                    </td>
                    <td class="column-2">{{ $ctproduct->name }}</td>
                    <td class="column-3">{{ number_format($ctproduct->price_sale, 0, '', '.') }}</td>
                    <td class="column-4">{{ $ctproduct->SL }}</td>
                    <td class="column-5">
                            {{$sizes->size}}
                    </td>
                    <td class="column-5">
                            {{$maus->mau}}
                    </td>
                    <td class="column-6">{{ number_format($ctproduct->price_sale, 0, '', '.') }}</td>
                </tr>
            @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td colspan="4" class="text-right" style="font-size:20px; font-family: emoji;
                        font-weight: bold; color:black">
                        Tiền cần thanh toán:
                    </td>
                    <td style="font-size:20px; font-family: emoji; font-weight: bold; color:black">
                        @foreach($cttt as $key => $cttts)
                        {{ number_format($cttts->tongtien, 0, '', '.') }} VND
                        @endforeach
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
        <!-- Footer -->
        @include('footer')

    </body>
</html>