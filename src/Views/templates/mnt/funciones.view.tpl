<section class="depth-1">
  <h1>Trabajar con Funciones</h1>
</section>
<section class="WWList">
  <table >
    <thead>
      <tr>
      <th>Código</th>
      <th>Correo</th>
      <th>Estado</th>
      <th>
        {{if CanInsert}}
        <a href="index.php?page=Mnt_Funciones&mode=INS&id=0">Nuevo</a>
        {{endif CanInsert}}
      </th>
      </tr>
    </thead>
    <tbody>
      {{foreach Funciones}}
      <tr>
        <td>{{fncod}}</td>
        <td>
          {{if ~CanView}}
          <a href="index.php?page=Mnt_Funciones&mode=DSO&id={{fncod}}">{{fndsc}}</a>
          {{endif ~CanView}}

          {{ifnot ~CanView}}
              {{fndsc}}
          {{endifnot ~CanView}}
        </td>
        <td>{{fnest}}</td>
        <td>
          {{if ~CanUpdate}}
          <a href="index.php?page=Mnt_Funciones&mode=UPD&id={{fncod}}"
            class="btn depth-1 w48" title="Editar">
            <i class="fas fa-edit"></i>
          </a>
          {{endif ~CanUpdate}}
          &nbsp;
          {{if ~CanDelete}}
          <a href="index.php?page=Mnt_Funciones&mode=DEL&id={{fncod}}"
            class="btn depth-1 w48" title="Eliminar">
            <i class="fas fa-trash-alt"></i>
          </a>
          {{endif ~CanDelete}}
        </td>
      </tr>
      {{endfor Funciones}}
    </tbody>
  </table>
</section>