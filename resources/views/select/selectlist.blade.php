
	<select style="width: 320px; height: 40px;text-align:center;" class="thanhpho" id="prod_cat_id" name="city">
		<option value="0" disabled="true" selected="true"> --Thành Phố--</option>
		@foreach($prod as $cat)
			<option value="{{$cat->id}}">{{$cat->tentp}}</option>
		@endforeach
	</select>
	<br>
	<br>
	<select style="width: 320px; height: 40px;text-align:center;" class="quanhuyen" name = "district" id="quanhuyen">
		<option value="0" disabled="true" selected="true"> --Quận Huyện--</option>
		@foreach($prod as $cat)
			<option value="{{$cat->id}}">{{$cat->tenqh}}</option>
		@endforeach
	</select>
	<br>
	<br>
	<select style="width: 320px; height: 40px;text-align:center;" class="phuongxa" name="ward" id="phuongxa">
		<option value="0" disabled="true" selected="true">  --Phường Xã--</option>
	</select>
	<br>
	<br>
	

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('change','.thanhpho',function(){
			var cat_id=$(this).val();
			var div=$(this).parent();
			var op=" ";
			$.ajax({
				type:'get',
				url:'{!!URL::to('findProductName')!!}',
				data:{'id':cat_id},
				success:function(data){
					op+='<option value="0" selected disabled> Chose Quan Huyen</option>';
					for(var i=0;i<data.length;i++){
					op+='<option value="'+data[i].id+'">'+data[i].tenqh+'</option>';
				   }
				   div.find('.quanhuyen').html(" ");
				   div.find('.quanhuyen').append(op);
				},
				error:function(){
				}
			});
		});

	});
</script>

<script type="text/javascript">
	$(document).ready(function(){

		$(document).on('change','.quanhuyen',function(){
			console.log(" its change");

			var cat_id=$(this).val();
			var div=$(this).parent();

			var op=" ";

			$.ajax({
				type:'get',
				url:'{!!URL::to('findPhuongXa')!!}',
				data:{'id':cat_id},
				success:function(data){
					//console.log('success');

					//console.log(data);

					//console.log(data.length);
					op+='<option value="0" selected disabled> chose Phuong Xa</option>';
					for(var i=0;i<data.length;i++){
						op+='<option value="'+data[i].id+'">'+data[i].tenpx+'</option>';
				   }

				   div.find('.phuongxa').html(" ");
				   div.find('.phuongxa').append(op);
				},
				error:function(){

				}
			});
		});
	});
</script>

