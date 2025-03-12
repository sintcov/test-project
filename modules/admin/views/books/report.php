
<p>Книга написаны в диапозоне от 01.03.2025 по 25.03.2025</p>

<form action="report" method="GET">
<div class="row">
  <div class="col-md-4">
    <label for="exampleInputEmail1" class="form-label">Период С</label>
    <input type="date" class="form-control" name="date-start">
  </div>
  <div class="col-md-4">
    <label for="exampleInputPassword1" class="form-label">Период По</label>
    <input type="date" class="form-control" name="date-end">
  </div>
   <div class="col-md-3"><button type="submit" class="btn btn-primary" style="margin-top: 30px;">Поиск</button></div>
</div>
   
</form>


<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Автор</th>
      <th scope="col">Количество книг</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 0; foreach ($model as $key => $item): $i++;?>
    <tr>
      <th scope="row"><?=$i?></th>
      <td><?=$item["FIO"]?></td>
      <td><?=$item["total"]?></td>

    </tr>
    <?php endforeach;?>
  </tbody>
</table>
