<!DOCTYPE html>
<html>
     <body>
        <table>
             <tr>
              <td colspan=11 rowspan =2  style="font-weight: bold;font-size: 25px !important;width : 7px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 5px solid #878783; ">LISTA DE INCIDENCIAS </td>
             </tr>
             <td colspan=1 rowspan =1  ></td>

        </table>
        <br>
      <div style ="padding: 15px !important;">
       
        <div class="row">
        <div class="col-12">
        
          <table>

            <tr>
                
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 7px;text-align : center ;background-color:  #0794C1;color:  #FFFFFF; border: 5px solid #878783; height: 26px;"></td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 25px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;	">Nombre </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 20px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;	">DNI </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 20px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;	">Teléfono </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 30px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;">Código de Alerta </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 30px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;	">Tipo de Alerta </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 25px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;	">Fecha </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 45px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;	">Dirección de la Alerta </td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 25px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;">Latitud</td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 27px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;">Longitud</td>
              <td colspan=1 rowspan =1  style="font-weight: bold;font-size: 13px !important;width : 22px;text-align : center ;background-color: #0794C1;color:  #FFFFFF;border: 2px solid #878783;padding 25px;">Estado</td>
           
              <td colspan=1 rowspan =1  ></td>

            </tr>
         
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $datas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
                <tr>
                      <td colspan=1 style="text-align : center;color:  #FFFFFF ;background-color: #0794C1;border: 2px solid #878783;padding 25px;"><?php echo e($index+1); ?></td>
                      <td colspan=1 style="border: 2px solid #878783;" ><?php echo e($datas->usuario[0]->name_pers . " ".$datas->usuario[0]->patname_pers . " ".$datas->usuario[0]->matname_pers); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->usuario[0]->dni_pers); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->usuario[0]->phone_pers); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->municipal[0]->code_munser); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->municipal[0]->description_munser); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->date_alert); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->address_alert); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->latitude_alert); ?></td>
                      <td colspan=1 style="text-align : center ;border: 2px solid #878783;"><?php echo e($datas->length_alert); ?></td>

             
                       <?php if($datas->attended_alert == 1 ): ?>
                       <td colspan=1 style="font-weight: bold;text-align : center ;border: 2px solid #878783;"><?php echo e("ATENTIDO"); ?></td>
                       <?php else: ?>
                        <td colspan=1 style="font-weight: bold;text-align : center ;border: 2px solid #878783;"><?php echo e("NO ATENDIDO"); ?></td>
                       <?php endif; ?>
                       
                       <td colspan=1 rowspan =1  ></td>

        
                    </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </table>
        </div>

      </div>
      </div>  
        
   </body>
     
</html><?php /**PATH /home/ubuntu/environment/ApiSanLuis/resources/views/excel.blade.php ENDPATH**/ ?>