<?php if (!defined('APPLICATION')) exit();
$CountDiscussions = 0;
$CategoryID = isset($this->_Sender->CategoryID) ? $this->_Sender->CategoryID : '';
$OnCategories = strtolower($this->_Sender->ControllerName) == 'categoriescontroller' && !is_numeric($CategoryID);
if ($this->Data !== FALSE) {
   foreach ($this->Data->Result() as $Category) {
      $CountDiscussions = $CountDiscussions + $Category->CountDiscussions;
   }
   ?>
<div class="Box BoxCategories">
   <ul class="PanelInfo PanelCategories">
   <?php
   echo '<li class="'.($OnCategories ? ' Active ' : '').'AllCategories">'.Wrap(Anchor(Gdn_Format::Text(T('All Categories')), '/categories'), 'strong')
      .' <span class="Aside"><span class="Count">'.Gdn_Format::BigNumber($CountDiscussions, 'html').'</span></span></li>';

   $MaxDepth = C('Vanilla.Categories.MaxDisplayDepth');
   $DoHeadings = C('Vanilla.Categories.DoHeadings');
   
   foreach ($this->Data->Result() as $Category) {
      if ($Category->CategoryID < 0 || $MaxDepth > 0 && $Category->Depth > $MaxDepth)
         continue;

      if ($DoHeadings && $Category->Depth == 1)
         $CssClass = 'Heading';
      else
         $CssClass = 'Depth'.$Category->Depth.($CategoryID == $Category->CategoryID ? ' Active' : '');
      
      echo '<li class="ClearFix '.$CssClass.'">';

      if ($DoHeadings && $Category->Depth == 1) {
         echo Gdn_Format::Text($Category->Name);
      } else {
         echo Wrap(Anchor(Gdn_Format::Text($Category->Name), '/categories/'.rawurlencode($Category->UrlCode)), 'strong')
            .' <span class="Aside"><span class="Count">'.number_format($Category->CountAllDiscussions).'</span></span>';
      }
      echo "</li>\n";
   }
?>
   </ul>
</div>
   <?php
}