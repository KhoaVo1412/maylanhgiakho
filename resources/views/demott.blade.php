
<form action="{{ url('/vnpay') }}" method="POST">
    @csrf
    <input type="hidden" name="thanhtienvnpay" value="{{$priceEnd}}">
    <input type="hidden" name="tongtienvnpay" value="{{$total}}">
    <input type="hidden" name="namevnpay" value="{{Auth::user()->name}}">
    <input type="hidden" name="phonevnpay"  value="{{Auth::user()->phone}}">
    <input type="hidden" name="addressvnpay" value="{{Auth::user()->address}}">
    <input type="hidden" name="emailvnpay" value="{{Auth::user()->email}}">
    <input type="hidden" name="contentvnpay" id="textarealay" value=""> 
    <input type="hidden" name="ptttvnpay" value="2"> 
    <input type="hidden" name="dsttvnpay" value="1"> 
    <input type="hidden" name="sizevnpay" id="sizevnpay" value="{{ $sizesss }}"> 
    <input type="hidden" name="mauvnpay" id="mauvnpay" value="{{ $mausss }}"> 

    <button type="submit" name="redirect" style="margin: -564px 0px 42px 500px;position: absolute;border: 1px solid;
    border-radius: 50px;
    width: 177px;
    background-color: #f3f3f3;">Thanh Toan VNPay</button>
    
</form>

