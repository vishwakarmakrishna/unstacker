<?php if (!empty($services)) {
?>
<div class="col-md-12 col-xl-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title"><?=(isset($cate_name)) ? $cate_name : lang("Lists")?></h3>
      <div class="card-options">
        <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
        <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
      </div>
    </div>
    <?php if (!empty($services)) {
      $j = 1;
    ?>
    <div class="table-responsive">
      <table class="table table-hover table-bordered table-outline table-vcenter card-table">
        <thead>
          <tr>
            <?php
              if (get_role("admin")) {
            ?>
            <th class="text-center w-1">
              <div class="custom-controls-stacked">
                <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input check-all" data-name="chk_<?=$j?>">
                  <span class="custom-control-label"></span>
                </label>
              </div>
            </th>
            <?php }?>
            <th class="text-center w-1">ID</th>
            <th><?php echo lang("Name"); ?></th>
            <?php if (!empty($columns)) {
              foreach ($columns as $key => $row) {
            ?>
            <th class="text-center"><?=$row?></th>
            <?php }}?>
            
            <?php
              if (get_role("admin") || get_role("supporter")) {
            ?>
            <th><?=lang("Action")?></th>
            <?php }?>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($services)) {

            $i = 0;
            foreach ($services as $key => $row) {
            $i++;
          ?>
          <tr class="tr_<?php echo (get_role('admin')) ? $row->ids : $row->id ; ?>">
            <?php
              if (get_role("admin")) {
            ?>
            <th class="text-center w-1">
              <div class="custom-controls-stacked">
                <label class="custom-control custom-checkbox">
                  <input type="checkbox" class="custom-control-input chk_<?=$j?>"  name="ids[]" value="<?=$row->ids?>">
                  <span class="custom-control-label"></span>
                </label>
              </div>
            </th>
            <?php }?>
            <td class="text-center text-muted"><?=$row->id?></td>
            <td>
              <div class="title"> <?=$row->name?> </div>
            </td>
            
            <?php
              if (get_role("admin") || get_role("supporter")) {
            ?>
            <td style="width: 10%;">
              <div class="title">
                <?php
                  if (!empty($row->add_type && $row->add_type == "api")) {
                    echo truncate_string($row->api_name, 13);
                  }else{
                    echo lang('Manual');
                  }
                ?>
              </div>
              <div class="text-muted small">
                <?=(!empty($row->api_service_id))? $row->api_service_id: ""?>
              </div>
            </td>
            <?php }?>
            <td class="text-center" style="width: 8%;">
              <div>
                <?php
                  $service_price = $row->price;
                  if (!get_role('admin') && isset($custom_rates[$row->id]) ) {
                    $service_price = $custom_rates[$row->id]['service_price'];
                  }
                ?>
                <?php echo (double)$service_price; ?>
              </div>
              <?php 
                if (get_role("admin") && isset($row->original_price)) {
                  if ($row->original_price > $row->price) {
                    $text_color = "text-danger";
                  }else{
                    $text_color = "text-muted";
                  }
                  echo '<small class="'.$text_color.'">'. (double)$row->original_price .'</small>';
                }
              ?>
            </td>

            <td class="text-center" style="width: 8%;"><?=$row->min?> / <?=$row->max?></td>

            <td style="width: 6%;">
              <button class="btn btn-info btn-sm" type="button" class="dash-btn" data-toggle="modal" data-target="#<?php echo $row->ids; ?>"><?=lang("Details")?></button>
              <div id="<?php echo $row->ids; ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                <?php
                  $this->load->view('descriptions', ['service' => $row]);
                ?>
              </div>
            </td>

            <?php
              if (get_role("admin") || get_role("supporter")) {
            ?>
            <td class="w-1 text-center">
              <?php if(!empty($row->dripfeed) && $row->dripfeed == 1){?>
                <span class="badge badge-info"><?=lang("Active")?></span>
                <?php }else{?>
                <span class="badge badge-warning"><?=lang("Deactive")?></span>
              <?php }?>
            </td>

            <td class="w-1 text-center">
              <label class="custom-switch">
                <input type="checkbox" name="item_status" data-id="<?php echo $row->id; ?>" data-action="<?php echo cn($module.'/ajax_toggle_item_status/'); ?>" class="custom-switch-input ajaxToggleItemStatus" <?php if(!empty($row->status) && $row->status == 1) echo 'checked'; ?>>
                <span class="custom-switch-indicator"></span>
              </label>
            </td>
            
            <td class="text-center" style="width: 5%;">
              <div class="item-action dropdown">
                <a href="javascript:void(0)" data-toggle="dropdown" class="icon"><i class="fe fe-more-vertical"></i></a>
                <div class="dropdown-menu">
                  
                  <a href="<?=cn("$module/update/".$row->ids)?>" class="dropdown-item ajaxModal"><i class="dropdown-icon fe fe-edit"></i> <?=lang('Edit')?> </a>
                  <?php
                    if (get_role("admin")) {
                  ?>
                  <a href="<?=cn("$module/ajax_delete_item/".$row->ids)?>" class="dropdown-item ajaxDeleteItem"><i class="dropdown-icon fe fe-trash"></i> <?=lang('Delete')?> </a>
                  <?php }?>
                </div>
              </div>
            </td>
            <?php }?>
          </tr>
          <?php }}?>
          
        </tbody>
      </table>
    </div>
    <?php }?>
  </div>
</div>
<?php }else{
  echo Modules::run("blocks/empty_data");
}?>
