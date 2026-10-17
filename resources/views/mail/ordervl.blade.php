<h2>Chào {{ $name }},</h2>
    <p>
        <b style="font-size: 40px; text-align: center">Bạn đã đặt hàng thành công tại cửa hàng ARB</b>
    </p>
     <h4>Ngày đặt hàng: 
        <?php
        $thoigian=$tg;
        echo date('H:m:s d/m/Y', strtotime($thoigian));
        ?>
    </h4>
    <h4>+ Phương thức thanh toán: {{ $pttt }}</h4>
    

    <h4>+ Chi tiết sản phẩm</h4>
    <table border="1" cellspacing="0" cellpadding="10" width="400">
        <thead> 
            <tr>
                <th>STT</th>
                <th>Tên SP</th>
                <th>Giá</th>
                <th>Số lượng</th>
                <th>Size</th>
                <th>Màu</th>
                <th>Thành tiền</th>
            </tr>
        </thead>
        <tbody>
            <?php $n = 1; ?>
            @foreach($items as $item)
            <tr>
                <td>{{ $n }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->qty }}</td>
                <td>{{ $item->options->sizes }}</td>
                <td>{{ $item->options->colors }}</td>
                <td>{{ $item->price*$item->qty}}</td>
            </tr>
            <?php $n++; ?>
            @endforeach
        </tbody>
    </table>