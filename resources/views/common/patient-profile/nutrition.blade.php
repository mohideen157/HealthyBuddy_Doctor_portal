@if($nutritions->isEmpty())
	<h3> Not Data Found </h3>
@endif

@foreach($nutritions as $nutrition)
<div class="row">
	<div class="col table-responsive">
		<table class="table-bordered profile" width="100%">
			<tbody>
				<tr>
					<th colspan="5" class="title-head">{{ $nutrition['type'] ?? '-' }}</th>
					<th class="title-head"></th>
				</tr>
				<tr>
					<th>Type</th>
					<td id="type">{{ $nutrition['type']  ?? '-' }}</td>
					<th>Date</th>
					<td id="date">{{ $nutrition['date']  ?? '-' }}</td>
					<th>Time</th>
					<td id="time">{{ $nutrition['time']  ?? '-' }}</td>
				</tr>
				<tr>
					<th>Quantity</th>
					<td id="quantity">{{ $nutrition['quantity']  ?? '-' }}</td>
					<th>Foodname</th>
					<td id="foodname">{{ $nutrition['foodname']  ?? '-' }}</td>
					<th>Calories</th>
					<td id="calories">{{ $nutrition['calories']  ?? '-' }}</td>
				</tr>
				<tr>
					<th>Totalfat</th>
					<td id="totalfat">{{ $nutrition['totalfat']  ?? '-' }}</td>
					<th>Saturated Fat</th>
					<td id="saturatedfat">{{ $nutrition['saturatedfat'] ?? '-' }}</td>
					<th>Sodium</th>
					<td id="sodium">{{ $nutrition['sodium'] ?? '-' }}</td>
				</tr>
				<tr>
					<th>Cholestrol</th>
					<td id="cholestrol">{{ $nutrition['cholestrol']  ?? '-'  }}</td>
					<th>Carbohydrate</th>
					<td id="carbohydrate">{{ $nutrition['carbohydrate']  ?? '-'  }}</td>
					<th>Protein</th>
					<td id="protein">{{ $nutrition['protein']  ?? '-'  }}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endforeach