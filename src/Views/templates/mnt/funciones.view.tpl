<section class="depth-1">
  <h1>Funciones</h1>
</section>
<section class="WWList">
  <table >
    <thead>
      <tr>
      <th>Código</th>
      <th>Descripcion</th>
      <th>Estado</th>
      <th>Tipo</th>
      <th>
        <a href="index.php?page=Mnt_Funcion&mode=INS&id=0">Nuevo</a>
      </th>
      </tr>
    </thead>
    <tbody>
      {{foreach funciones}}
      <tr>
        <td>{{fncod}}</td>
        <td><a href="index.php?page=Mnt_Funcion&mode=DSP&fncod={{fncod}}">{{fndsc}}</a></td>
        <td>{{fnest}}</td>
        <td>{{fntyp}}</td>
        <td>
          <td><a href="index.php?page=Mnt_Funcion&mode=UPD&fncod={{fncod}}">Editar</a>&nbsp;
            <a href="index.php?page=Mnt_Funcion&mode=DEL&fncod={{fncod}}">Eliminar</a></td>
      </tr>
      {{endfor funciones}}
    </tbody>
  </table>
</section>