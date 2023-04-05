<h1>Gestión de Roles</h1>
<section class="WWFilter">

</section>
<section class="WWList">
  <table>
    <thead>
      <tr>
        <th>Código</th>
        <th>Rol</th>
        <th>Estado</th>
        <th>
          {{if new_enabled}}
          <button id="btnAdd">Nuevo</button>
          {{endif new_enabled}}
        </th>
      </tr>
    </thead>
    <tbody>
      {{foreach roles}}
      <tr>
        <td>{{rol_id}}</td>
        <td><a href="index.php?page=Mnt_Rol&mode=DSP&rol_id={{rol_id}}">{{rol_dsc}}</a></td>
        <td>{{rol_est}}</td>
        <td>
          {{if ~edit_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="Mnt_Rol"/>
              <input type="hidden" name="mode" value="UPD" />
              <input type="hidden" name="rol_id" value={{rol_id}} />
              <button type="submit">Editar</button>
          </form>
          {{endif ~edit_enabled}}
          {{if ~delete_enabled}}
          <form action="index.php" method="get">
             <input type="hidden" name="page" value="Mnt_Rol"/>
              <input type="hidden" name="mode" value="DEL" />
              <input type="hidden" name="rol_id" value={{rol_id}} />
              <button type="submit">Eliminar</button>
          </form>
          {{endif ~delete_enabled}}
        </td>
      </tr>
      {{endfor roles}}
    </tbody>
  </table>
</section>
<script>
   document.addEventListener("DOMContentLoaded", function () {
      document.getElementById("btnAdd").addEventListener("click", function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=mnt_Rol&mode=INS&rol_id=0");
      });
    });
</script>
