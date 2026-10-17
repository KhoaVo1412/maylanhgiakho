@extends('admin.main')

@section('content')
    <div class="customer mt-3">
        <ul>
            <li>Tên: <strong>{{ $cthd->name }}</strong></li>
            <li>SĐT: <strong>{{ $cthd->phone }}</strong></li>
            <li>Địa Chỉ: <strong>{{ $cthd->address }}</strong></li>
            <li>Email: <strong>{{ $cthd->email }}</strong></li>
            <li>Ghi Chú: <strong>{{ $cthd->content }}</strong></li>
        </ul>
    </div>

    <div class="carts">
        
        <table class="table">
            <tbody>
            <tr class="table_head">
                <th class="column-1">Hình ảnh</th>
                <th class="column-2">Tên sản phẩm</th>
                <th class="column-3">Giá</th>
                <th class="column-4">Số lượng</th>
                <th class="column-5">Mã Lực</th>
                <th class="column-5">Màu</th>
                <th class="column-6">Tổng tiền</th>
            </tr>

            @foreach($ctproducts as $key => $ctproduct)
                
                <tr>
                    <td class="column-1">
                        <div class="how-itemcart1">
                            <img src="{{ $ctproduct->thumb }}" alt="IMG" style="width: 100px">
                        </div>
                    </td>
                    <td class="column-2">{{ $ctproduct->name }}</td>
                    <td class="column-3">{{ number_format($ctproduct->price_sale, 0, '', '.') }} VND</td>
                    <td class="column-4">{{ $ctproduct->SL }}</td>
                    <td class="column-5">
                        {{$ctproduct->size}}
                        {{-- @foreach ($sizes as $key => $Size)
                            {{$Size->size}}
                        @endforeach --}}
                    </td>
                    <td class="column-5">
                        {{-- @foreach ($maus as $key => $Mau)
                            {{$Mau->mau}}
                        @endforeach --}}
                        {{$ctproduct->mau}}

                    </td>
                    <td class="column-6">{{ number_format($ctproduct->thanhtien, 0, '', '.') }}</td>
                </tr>
            @endforeach
                {{-- <tr>
                    <td></td>
                    <td></td>
                    <td colspan="4" class="text-right" style="font-size:20px; font-family: emoji;
                        font-weight: bold;">
                        Total Money
                    </td>
                    <td style="font-size:20px; font-family: emoji; font-weight: bold;">
                        {{ number_format($total, 0, '', '.') }}
                    </td>
                </tr> --}}
            </tbody>
        </table>
    </div>
@endsection


