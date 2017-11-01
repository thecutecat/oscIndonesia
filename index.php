<?php

  require('includes/application_top.php');

  $category_depth = 'top';

  if (isset($cPath) && tep_not_null($cPath)) {

    $categories_products_query = tep_db_query("SELECT count(*) as total from " . TABLE_PRODUCTS_TO_CATEGORIES . " WHERE categories_id = '" . (int)$current_category_id . "'");

    $cateqories_products = tep_db_fetch_array($categories_products_query);

    if ($cateqories_products['total'] > 0) {

      $category_depth = 'products'; 

    } else {

      $category_parent_query = tep_db_query("SELECT count(*) as total from " . TABLE_CATEGORIES . " WHERE parent_id = '" . (int)$current_category_id . "'");

      $category_parent = tep_db_fetch_array($category_parent_query);

      if ($category_parent['total'] > 0) {

        $category_depth = 'nested'; 

      } else {

        $category_depth = 'products'; 

      }

    }

  }



   require(DIR_WS_LANGUAGES . $language . '/' . FILENAME_DEFAULT);

   

   //for meta

   $val = get_meta($current_category_id);

   if($current_category_id < 1){ $keyword = $val; $desc = $val; }else{ 

      $keyword = 'Kategori Produk '.$val; $desc = 'Jual '.$val; }

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/htm/loose.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<meta http-equiv="content-language" content="id" />

        <title><?php echo TITLE; ?></title>

	<meta name="description" itemprop="description" content="Distributor Resmi Telepon dan PABX Panasonic di Jakarta. Jual Telepon, PABX, Mesin Fax, Kamera CCTV, Walky Talky Motorolla, Aksesoris Telepon Harga Grosir dan Eceran. Telepon 021-5330555" />

	<meta name="keywords" itemprop="keywords" content="toko telepon,pabx panasonic,distributor panasonic,distributor pabx panasonic,distributor telepon panasonic,telepon panasonic,harga telepon panasonic,jual telepon murah,jual pabx murah,grosir panasonic,panasonic jakarta,panasonic indonesia,distributor mesin fax,mesin fax panasonic,distributor kamera cctv,jual aksesoris telepon,walky talky motorolla,walky talky uniden,pabx panasonic kx-tes824,pabx panasonic kx-tda100dbp,pabx panasonic kx-tda600,pabx panasonic kx-tde600,pabx panasonic kx-ns300"/>

        <meta name="robots" content="index,follow,noodp,noydir" />
        <meta name="msvalidate.01" content="44A50869C4D7FD02E2179DFB484F1E01" />
        <meta name="alexaVerifyID" content="cbgS5Nmp99cvoKkgxXbhXGCVbGs"/> 
	<base href="<?php echo (($request_type == 'SSL') ? HTTPS_SERVER : HTTP_SERVER) . DIR_WS_CATALOG; ?>">

	<link href="images/logo.ico" rel="shortcut icon" type="image/x-icon" />

	<link rel="stylesheet" type="text/css" href="style/style.css" />

	<script language="JavaScript1.2" src="script/mm_menu.js" type="text/javascript"></script>

	<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>

	<script type="text/javascript">

	function equalHeight(group) {

		var tallest = 0;

		group.each(function() {

			var thisHeight = $(this).height();

			if(thisHeight > tallest) {

				tallest = thisHeight;

			}

		});

		group.height(tallest);

	}

	</script>

    <?php include('includes/carousel.php');?>

</head>

<body>

   <div align="center">

	    <?php include('includes/top.php'); ?>

		<div id="main">

			<?php include('includes/header.php'); ?>

			<div class="spacer" style="height:5px;"></div>

			<?php 

			if (isset($cPath) && tep_not_null($cPath)) {

				echo '';

				}else{

					include('includes/home-slideshow.php');

				}

				?>

			

			<div id="content">

			    <div style="float:left; margin-left:5px; width:212px;">

			    <?php include('includes/column_left.php'); ?>

				<div style="height:500px; width:3px; float:left;"></div>

				<div style="max-width:780px; float:left;" align="center">

				 <div class="box_left">

				 

				 <?php 

					if (isset($cPath) && tep_not_null($cPath)) {

						echo $carousel;

						}else{

							echo '';

						}

						?>  

				 

<?php

  if ($category_depth == 'nested') { //echo 'iki nested';

    $category_query = tep_db_query("SELECT cd.categories_name, c.categories_image FROM " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd 

	      WHERE c.categories_id = '" . (int)$current_category_id . "' and cd.categories_id = '" . (int)$current_category_id . "' 

		  AND cd.language_id = '" . (int)$languages_id . "'");

    $category = tep_db_fetch_array($category_query);

?> 

<table style="display:none;" border="0" width="90%" cellspacing="0" cellpadding="2">

  <tr><td colspan="<?php echo MAX_DISPLAY_CATEGORIES_PER_ROW; ?>">&nbsp;</td></tr>

  <tr>

<?php

    if (isset($cPath) && strpos('_', $cPath)) {

      // check to see if there are deeper categories within the current category

      $category_links = array_reverse($cPath_array);

      for($i=0, $n=sizeof($category_links); $i<$n; $i++) {

        $categories_query = tep_db_query("SELECT count(*) as total from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd WHERE c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "'");

        $categories = tep_db_fetch_array($categories_query);

        if ($categories['total'] < 1) {

          // do nothing, go through the loop

        } else {

          $categories_query = tep_db_query("SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd WHERE c.parent_id = '" . (int)$category_links[$i] . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");

          break; // we've found the deepest category the customer is in

        }

      }

    } else {

      $categories_query = tep_db_query("SELECT c.categories_id, cd.categories_name, c.categories_image, c.parent_id from " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd WHERE c.parent_id = '" . (int)$current_category_id . "' and c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' order by sort_order, cd.categories_name");

    }



    $number_of_categories = tep_db_num_rows($categories_query);



    $rows = 0;

	

    while ($categories = tep_db_fetch_array($categories_query)) {

      $rows++;

      $cPath_new = tep_get_path($categories['categories_id']);

      $cPath_new = str_replace('cPath=','',$cPath_new);

	  $width = (int)(100 / MAX_DISPLAY_CATEGORIES_PER_ROW) . '%';

	  $link = tep_session_is_registered('customer_id') ? tep_href_link('index.php','cPath='.$cPath_new) : $link = 'category/' . $cPath_new .'-'. $categories['categories_name'] . '/';

      echo '<td align="center" class="smallText" width="' . $width . '" valign="top"><a href="'.$link.'">' . tep_image(DIR_WS_IMAGES . $categories['categories_image'], $categories['categories_name'], '', '150' ) . '<br>' . $categories['categories_name'] . '</a></td>' . "\n"; //SUBCATEGORY_IMAGE_WIDTH - SUBCATEGORY_IMAGE_HEIGHT

      if ((($rows / MAX_DISPLAY_CATEGORIES_PER_ROW) == floor($rows / MAX_DISPLAY_CATEGORIES_PER_ROW)) && ($rows != $number_of_categories)) {

        echo '              </tr>' . "\n";

        echo '              <tr>' . "\n";

      }

    }

  

// needed for the new products module shown below

    $new_products_category_id = $current_category_id;

?>

 </tr>

 <tr><td colspan="<?php echo MAX_DISPLAY_CATEGORIES_PER_ROW; ?>">&nbsp;</td></tr>

</table>

<?php include(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS); ?>

<?php

  } elseif ($category_depth == 'products' || isset($_GET['manufacturers_id'])) { //echo 'ora nested kiy';

// create column list

    $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,

                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,

                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,

                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,

                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,

                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,

                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,

                         'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);


    asort($define_list);


    $column_list = array();

    reset($define_list);

    while (list($key, $value) = each($define_list)) {

      if ($value > 0) $column_list[] = $key;

    }

    $select_column_list = '';

    for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {

      switch ($column_list[$i]) {

        case 'PRODUCT_LIST_MODEL':

          $select_column_list .= 'p.products_model, ';

          break;

        case 'PRODUCT_LIST_NAME':

          $select_column_list .= 'pd.products_name, pd.products_short_description, ';

          break;

        case 'PRODUCT_LIST_MANUFACTURER':

          $select_column_list .= 'm.manufacturers_name, ';

          break;

        case 'PRODUCT_LIST_QUANTITY':

          $select_column_list .= 'p.products_quantity, ';

          break;

        case 'PRODUCT_LIST_IMAGE':

          $select_column_list .= 'p.products_image, ';

          break;

        case 'PRODUCT_LIST_WEIGHT':

          $select_column_list .= 'p.products_weight, ';

          break;

      }

    }


// show the products of a specified manufacturer

if (isset($_GET['manufacturers_id'])) { 

 if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {

 // We are asked to show only a specific category

 $listing_sql = "SELECT " . $select_column_list . " c.categories_name, p.products_id, p.manufacturers_id, p.products_price, p.products_price_usd, 

               p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price,

			   p.products_price) as final_price from (" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m,

			   " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c ) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id INNER JOIN categories_description c 

			   ON p2c.categories_id = c.categories_id WHERE p.manufacturers_id = m.manufacturers_id and 

			   m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id 

			   and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$_GET['filter_id'] . "'";

} else {

// We show them all

$listing_sql = "SELECT ". $select_column_list ." c.categories_name, p.products_id, p.manufacturers_id, p.products_price, p.products_price_usd, p.products_tax_class_id,

                IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as 

				final_price from (" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m) 

				INNER JOIN products_to_categories p2c ON p2c.products_id = p.products_id

				LEFT JOIN " . TABLE_SPECIALS . " s on p.products_id = s.products_id 

				INNER JOIN categories_description c ON p2c.categories_id = c.categories_id 

				WHERE  pd.products_id = p.products_id and pd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id =m.manufacturers_id 

				and m.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'";

}



} else {

// show the products in a given categorie

if (isset($_GET['filter_id']) && tep_not_null($_GET['filter_id'])) {

// We are asked to show only specific category

$listing_sql = "SELECT " . $select_column_list . "c.categories_name, p.products_id, p.manufacturers_id, p.products_price, p.products_price_usd, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from (" . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_MANUFACTURERS . " m, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id INNER JOIN categories_description c ON p2c.categories_id = c.categories_id WHERE p.manufacturers_id = m.manufacturers_id and m.manufacturers_id = '" . (int)$_GET['filter_id'] . "' and p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";

} else {

// We show them all

$listing_sql = "SELECT " . $select_column_list . "c.categories_name, p.products_id, p.manufacturers_id, p.products_price, p.products_price_usd, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from ((" . TABLE_PRODUCTS_DESCRIPTION . " pd, " . TABLE_PRODUCTS . " p) left join " . TABLE_MANUFACTURERS . " m on p.manufacturers_id = m.manufacturers_id, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c) left join " . TABLE_SPECIALS . " s on p.products_id = s.products_id INNER JOIN categories_description c ON p2c.categories_id = c.categories_id WHERE p.products_id = p2c.products_id and pd.products_id = p2c.products_id and pd.language_id = '" . (int)$languages_id . "' and p2c.categories_id = '" . (int)$current_category_id . "'";

}



}

$listing_sql .= "AND p.`products_id`
IN (

SELECT `products_id`
FROM `products`
WHERE products_date_available IS NULL
OR `products_date_available` < NOW( )
)";
/*

*/
//echo $listing_sql;



//if ( (!isset($_GET['sort'])) || (!ereg('[1-8][ad]', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {
if ( (!isset($_GET['sort'])) || (!preg_match('/[1-8][ad]/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > sizeof($column_list)) ) {

      for ($i=0, $n=sizeof($column_list); $i<$n; $i++) {

        if ($column_list[$i] == 'PRODUCT_LIST_NAME') {

          $_GET['sort'] = $i+1 . 'a';

          $listing_sql .= " order by p.products_sortorder, pd.products_name, p.`products_ordered` ";

          break;

        }

      }

    } else {

      $sort_col = substr($_GET['sort'], 0 , 1);

      $sort_order = substr($_GET['sort'], 1);

      $listing_sql .= ' order by ';

      switch ($column_list[$sort_col-1]) {

        case 'PRODUCT_LIST_MODEL':

          $listing_sql .= "p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", p.products_sortorder, pd.products_name";

          break;

        case 'PRODUCT_LIST_NAME':

          $listing_sql .= "pd.products_name " . ($sort_order == 'd' ? 'desc' : '');

          break;

        case 'PRODUCT_LIST_MANUFACTURER':

          $listing_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", p.products_sortorder, pd.products_name";

          break;

        case 'PRODUCT_LIST_QUANTITY':

          $listing_sql .= "p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ",p.products_sortorder, pd.products_name";

          break;

        case 'PRODUCT_LIST_IMAGE':

          $listing_sql .= "pd.products_name";

          break;

        case 'PRODUCT_LIST_WEIGHT':

          $listing_sql .= "p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", p.products_sortorder, pd.products_name";

          break;

        case 'PRODUCT_LIST_PRICE':

          $listing_sql .= "final_price " . ($sort_order == 'd' ? 'desc' : '') . ", p.products_sortorder, pd.products_name";

          break;

      }

    }

?>

<?php

// optional Product List Filter

    if (PRODUCT_LIST_FILTER > 0) {

      if (isset($_GET['manufacturers_id'])) {

        $filterlist_sql = "SELECT distinct c.categories_id as id, cd.categories_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_CATEGORIES . " c, " . TABLE_CATEGORIES_DESCRIPTION . " cd WHERE p.products_id = p2c.products_id and p2c.categories_id = c.categories_id and p2c.categories_id = cd.categories_id and cd.language_id = '" . (int)$languages_id . "' and p.manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "' order by cd.categories_name";

      } else {

        $filterlist_sql= "SELECT distinct m.manufacturers_id as id, m.manufacturers_name as name from " . TABLE_PRODUCTS . " p, " . TABLE_PRODUCTS_TO_CATEGORIES . " p2c, " . TABLE_MANUFACTURERS . " m WHERE p.manufacturers_id = m.manufacturers_id and p.products_id = p2c.products_id and p2c.categories_id = '" . (int)$current_category_id . "' order by m.manufacturers_name";

      }

      $filterlist_query = tep_db_query($filterlist_sql);

      if (tep_db_num_rows($filterlist_query) > 1) {

        echo '            <div class="filter">' . tep_draw_form('filter', tep_href_link(FILENAME_DEFAULT), 'get') . TEXT_SHOW . '&nbsp;';

        if (isset($_GET[osCsid])) {

       //tep_session_name() . '=' . tep_session_id()

	    echo tep_draw_hidden_field(tep_session_name(), tep_session_id());

        } 

		if (isset($_GET['manufacturers_id'])) {

          echo tep_draw_hidden_field('manufacturers_id', $_GET['manufacturers_id']);

          $options = array(array('id' => '', 'text' => TEXT_ALL_CATEGORIES));

        } else {

          echo tep_draw_hidden_field('cPath', $cPath);

          $options = array(array('id' => '', 'text' => TEXT_ALL_MANUFACTURERS));

        }

        echo tep_draw_hidden_field('sort', $_GET['sort']);

        while ($filterlist = tep_db_fetch_array($filterlist_query)) {

          $options[] = array('id' => $filterlist['id'], 'text' => $filterlist['name']);

        }

        echo tep_draw_pull_down_menu('filter_id', $options, (isset($_GET['filter_id']) ? $_GET['filter_id'] : ''), 'onchange="this.form.submit()"');

        echo '</form></div>' . "\n";

      }

    }


// Get the right image for the top-right

    $image = DIR_WS_IMAGES . 'table_background_list.gif';

    if (isset($_GET['manufacturers_id'])) {

      $image = tep_db_query("SELECT manufacturers_image from " . TABLE_MANUFACTURERS . " WHERE manufacturers_id = '" . (int)$_GET['manufacturers_id'] . "'");

      $image = tep_db_fetch_array($image);

      $image = $image['manufacturers_image'];

    } elseif ($current_category_id) {

      $image = tep_db_query("SELECT categories_image from " . TABLE_CATEGORIES . " WHERE categories_id = '" . (int)$current_category_id . "'");

      $image = tep_db_fetch_array($image);

      $image = $image['categories_image'];

    }

?>

<?php include(DIR_WS_MODULES . FILENAME_PRODUCT_LISTING); ?>

<?php } else { // default page ?>

				   <!--<div style="float:left; margin-left:15px;"><img src="images/ico_002.gif" /></div>

				   <div class="box-header-product">Penawaran Utama</div>-->

<?php   $sq = tep_db_query("SELECT `products_name`, `products_short_description`,p.`products_id`, `products_image`, `products_price` 

                     FROM `products` p, products_description pd

					 INNER JOIN highlight_product h ON h.products_id = pd.products_id  

                     WHERE `products_status`='1' and p.`products_id`=pd.`products_id`

                     ORDER BY highlight_product_order"); 				 

	   

	   $no = 0;

	   $nb =  tep_db_num_rows($sq);

	   while($br = tep_db_fetch_array($sq)){	

	   	$pr_link = my_href_link(FILENAME_PRODUCT_INFO, 'products_id=' .  $br[products_id], $br[products_id],$br[products_name]); 

					 ?>

					<div class="boxproductleft"> 

					  <div>

		<table height="120" width="100%" border="0" cellspacing="0" cellpadding="0">

         <tr>

           <td align="center" valign="middle"><a href="<?php echo $pr_link; ?>"><img src="images/foto_product/th_utama/<?php echo $br[products_image]; ?>" border="0" alt="" /></a></td>

         </tr>

         </table>

        </div>

					  

					  <strong><a href="<?php echo $pr_link; ?>"><?php echo $br[products_name]; ?></a></strong><br />

					  <div class="biasa"><?php echo sanitize_short_desc($br[products_short_description]); ?></div>

					  <div class="boxproductbottom">

					  <div class="price"><?php echo $currencies->format($br[products_price]); // $currencies->display_price($price, tep_get_tax_rate($listing['products_tax_class_id'])); ?></div>

					  <div class="boxproductbutton">

					  <form method="post" action="<?php echo tep_href_link('index.php','action=buy_now'); ?>">

					    <input type="hidden" value="<?php echo $br[products_id];  ?>" name="products_id" />

					    <input type="image" src="images/add_cart.gif" />

					  </form>

					  </div>

					  </div>

					  </div> 

				   

					<?php $no++; 

					    if(($no%3) == 0 || $no == ceil($nn / 3)){

					echo '<div class="clear" style="width:10px;"></div>';	

						 }

					       }//end while ?> 

				    

 <?php } ?>					 

				 </div>

				</div>

			</div>

			<div class="spacer"></div> 

			 <?php require(DIR_WS_INCLUDES . 'footer.php'); ?>

			<div class="spacer"></div> 

		</div>

		<?php require(DIR_WS_INCLUDES . 'copyright.php'); ?>

	</div>

	</div>

	<script type="text/javascript">

	$(document).ready(function() {

		equalHeight($(".boxproductleft"));

	});

	</script>


</body>

</html>

<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>