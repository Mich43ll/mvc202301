<h1>{{modedsc}}</h1>
<section class="row">
  <form action="index.php?page=Mnt_Funcion&mode={{mode}}&fncod={{fncod}}"
    method="POST"
    class="col-6 col-3-offset"
  >
    <section class="row">
    <label for="fncod" class="col-4">Código</label>
    <input type="hidden" id="fncod" name="fncod" value="{{fncod}}"/>
    <input type="hidden" id="mode" name="mode" value="{{mode}}"/>
     <input type="hidden" name="xssToken" value="{{xssToken}}"/>
    <input type="text" readonly name="fncoddummy" value="{{fncod}}"/>
    </section>


    <section class="row">
      <label for="fndsc" class="col-4">Funcion</label>
      <input type="text" {{readonly}} name="fndsc" value="{{fndsc}}" placeholder="Descripcion de Funcion"/>
    </section>


    <section class="row">
      <label for="fnest" class="col-4">Estado</label>
      <select id="fnest" name="fnest" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{fnest_ACT}}>Activo</option>
        <option value="INA" {{fnest_INA}}>Inactivo</option>
      </select>
    </section>

    <section class="row">
      <label for="fntyp" class="col-4">Tipo</label>
      <select id="fntyp" name="fntyp" {{if readonly}}disabled{{endif readonly}}>
        <option value="ACT" {{fntyp_ACT}}>Activo</option>
        <option value="INA" {{fntyp_INA}}>Inactivo</option>
      </select>
    </section>
    {{if has_errors}}
        <section>
          <ul>
            {{foreach general_errors}}
                <li>{{this}}</li>
            {{endfor general_errors}}
          </ul>
        </section>
    {{endif has_errors}}
    <section>
      {{if show_action}}
      <button type="submit" name="btnGuardar" value="G">Guardar</button>
      {{endif show_action}}
      <button type="button" id="btnCancelar">Cancelar</button>
    </section>
  </form>
</section>


<script>
  document.addEventListener("DOMContentLoaded", function(){
      document.getElementById("btnCancelar").addEventListener("click", function(e){
        e.preventDefault();
        e.stopPropagation();
        window.location.assign("index.php?page=Mnt_Funciones");
      });
  });
</script>