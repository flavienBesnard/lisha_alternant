<?php 
	$lisha1_id = 'lisha_zdev';

	// Force lisha language from framework language
	//$_GET['lng'] = $_SESSION[$ssid]['langue']; // Already done by language include of main page

	// Use framework connexion information from framework
	$_SESSION[$ssid]['lisha'][$lisha1_id] = new lisha(
														$lisha1_id,
														$ssid,
														__MYSQL__,
														array('user' => __LISHA_DATABASE_USER__,'password' => __LISHA_DATABASE_PASSWORD__,'host' => __LISHA_DATABASE_HOST__,'schema' => __LISHA_DATABASE_SCHEMA__),
														$path_root_lisha,
														false);	// Type of internal lisha ( false by default )

	// Create a reference to the session
	$obj_lisha_tran = &$_SESSION[$ssid]['lisha'][$lisha1_id];

	//==================================================================
	// Define main query
	//==================================================================
	$query = "
			SELECT
				`zdev_table`.`index`			AS `index`,
				`zdev_table`.`daterec` 		    AS `daterec`,
				`zdev_table`.`otherdate` 		AS `otherdate`,
				`zdev_table`.`description`	    AS `description`,
				DECODE(`zdev_table`.`password`,'hX*sqdkjf3_--é0Fz.')	AS `password`,
				`zdev_table`.`amount`			AS `amount`,
				UPPER(`zdev_table`.`amount`)	AS `upper`,
				`zdev_table`.`status`			AS `status`,
				CASE `zdev_table`.`status`
								WHEN 0
								THEN
									CONCAT('[div=home][size=3][b]     zerg[/b][/size]:',`zdev_table`.`status`,':[/div]')
								ELSE
									'OTHER'
								END AS `icon`,
				`zdev_table`.`status`			AS `MyGroupTheme`
			".$_SESSION[$ssid]['lisha']['configuration'][10]."
				`zdev_table`
				WHERE 1 = 1
				";
	$obj_lisha_tran->define_attribute('__main_query', $query);
	//==================================================================

	//==================================================================
	// Lisha display setup
	//==================================================================
	$obj_lisha_tran->define_nb_line(10);											// Row by page
	$obj_lisha_tran->define_size(100,'%',100,'%');									// Size of object
	$obj_lisha_tran->define_attribute('__active_readonly_mode', __RW__);			// Read & Write
	$obj_lisha_tran->define_attribute('__id_theme','red');							// Define style

	//$obj_lisha_tran->define_attribute('__active_title', false);						// Display or Hide title bar
	$obj_lisha_tran->define_attribute('__title', 'Red Lisha');						// Title

	$obj_lisha_tran->define_attribute('__max_lines_by_page', 20);					// Limit rows by page

	$obj_lisha_tran->define_attribute('__active_column_separation',false);
	$obj_lisha_tran->define_attribute('__active_row_separation',false);

	$obj_lisha_tran->define_attribute('__active_top_bar_page',true);
	$obj_lisha_tran->define_attribute('__active_bottom_bar_page',true);

	//$obj_lisha_tran->define_attribute('__active_user_doc', false);					// user documentation button
	$obj_lisha_tran->define_attribute('__active_tech_doc', true);					// technical documentation button
	$obj_lisha_tran->define_attribute('__active_ticket', true);						// Tickets link

	$obj_lisha_tran->define_attribute('__active_read_only_cells_edit', false);		// quick edit cell
	$obj_lisha_tran->define_attribute('__active_quick_search', true);				// Enable / disable total of entries left when typing ( False = Performance enhancement )


	$obj_lisha_tran->define_attribute('__background_picture', 'iknow.png');

	//$obj_lisha_tran->define_attribute('__display_mode', __LMOD__);				// Display mode : Don't touch if no idea what is that thing

	$obj_lisha_tran->define_attribute('__key_url_custom_view', 'f1');				// Defined key for quick custom view loader in url browser

	$obj_lisha_tran->define_attribute('__update_table_name', "zdev_table");		// Define table to update

	//$obj_lisha_tran->define_attribute('__active_insert_button', false);
	//$obj_lisha_tran->define_attribute('__active_delete_button', false);				// Enable / disable delete button
	//$obj_lisha_tran->define_attribute('__active_global_search', false);				// Enable / disable global search button


	$obj_lisha_tran->define_attribute('__column_name_group_of_color', "MyGroupTheme");		// ( Optional ) Define csutom column color name
	//==================================================================

	//==================================================================
	// define columns
	//==================================================================

		//==================================================================
		// define column : Date modification
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`daterec`','daterec','date',__DATE__,__WRAP__,__CENTER__,__PERCENT__,__DISPLAY__);
		//$obj_lisha_tran->define_attribute('__column_date_format','%d/%m/%Y','daterec');
		$obj_lisha_tran->define_attribute('__column_date_format','%Y-%m-%d','daterec');
		$obj_lisha_tran->define_attribute('__column_input_check_update', __REQUIRED__,'daterec');
		$obj_lisha_tran->define_input_focus('daterec', true);					// Focused
		//==================================================================

		//==================================================================
		// define column : Date modification
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`otherdate`','otherdate','Date Time !!',__DATE__,__WRAP__,__CENTER__,__PERCENT__,__DISPLAY__);
		$obj_lisha_tran->define_attribute('__column_date_format','%Y-%m-%d %H:%i:%s','otherdate');
		//$obj_lisha_tran->define_attribute('__column_input_check_update', __REQUIRED__,'otherdate');
		//==================================================================

		//==================================================================
		// define column : Password
		// Caution : MySQL column type Blob
		//==================================================================
		$obj_lisha_tran->define_column("DECODE(`zdev_table`.`password`,'hX*sqdkjf3_--é0Fz.')",'password','Encode/Decode',__TEXT__,__WRAP__,__LEFT__);
		//$obj_lisha_tran->define_attribute('__column_input_check_update', __REQUIRED__,'password');
		$obj_lisha_tran->define_col_rw_function('password',"ENCODE('__COL_VALUE__','hX*sqdkjf3_--é0Fz.')");
		$obj_lisha_tran->define_col_select_function('password',"DECODE(`zdev_table`.__COL_VALUE__,'hX*sqdkjf3_--é0Fz.')");
		//==================================================================

		//==================================================================
		// define column : Description
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`description`','description','Caption',__BBCODE__,__WRAP__,__LEFT__);
		$obj_lisha_tran->define_attribute('__column_input_check_update', __REQUIRED__,'description');
		//==================================================================

		//==================================================================
		// define column : amount
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`amount`','amount','normal',__BBCODE__,__WRAP__,__LEFT__);
		//$obj_lisha_tran->define_attribute('__column_display_mode',false,'amount');						
		//==================================================================

		//==================================================================
		// define column : compute
		//==================================================================
		$obj_lisha_tran->define_column('UPPER(`zdev_table`.`amount`)','upper','Upper',__TEXT__,__WRAP__,__LEFT__);
		$obj_lisha_tran->define_attribute('__column_input_check_update', __FORBIDDEN__,'upper');
		//$obj_lisha_tran->define_attribute('__column_display_mode',false,'amount');						
		//==================================================================

		//==================================================================
		// define column : identifier
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`index`','index','id',__TEXT__,__WRAP__,__CENTER__);
		//$obj_lisha_tran->define_attribute('__column_display_mode',true,'index');
		$obj_lisha_tran->define_attribute('__column_input_check_update', __FORBIDDEN__,'index');
		//==================================================================

		//==================================================================
		// define column : icon
		//==================================================================
		$obj_lisha_tran->define_column("CASE `zdev_table`.`status`
								WHEN 0
								THEN
									CONCAT('[div=home][size=3][b]     zerg[/b][/size]:',`zdev_table`.`status`,':[/div]')
								ELSE
									'OTHER'
								END",'icon','my_icon',__BBCODE__,__WRAP__,__CENTER__);
		$obj_lisha_tran->define_attribute('__column_input_check_update', __FORBIDDEN__,'icon');
		//==================================================================

		//==================================================================
		// define column : status
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`status`','status','status',__TEXT__,__WRAP__,__CENTER__);
		//$obj_lisha_tran->define_attribute('__column_display_mode',false,'status');
		$obj_lisha_tran->define_attribute('__column_input_check_update', __LISTED__,'status');

		// Match code
		$obj_lisha_tran->define_lov("	SELECT
											`main`.`A` AS `mode`
											".$_SESSION[$ssid]['lisha']['configuration'][10]."
											(
												SELECT 0 AS `A`
												UNION
												SELECT 1 AS `A`
												UNION
												SELECT 2 AS `A`
											 ) `main`
												WHERE 1 = 1
											",
									'Color index',
									'`main`.`A`',
									'mode'
								);
		$obj_lisha_tran->define_column_lov("`main`.`A`",'mode','myColor',__TEXT__,__WRAP__,__LEFT__);
		$obj_lisha_tran->define_column_lov_order('mode',__ASC__);
		//==================================================================

		//==================================================================
		// define column : SetOfColor
		//==================================================================
		$obj_lisha_tran->define_column('`zdev_table`.`status`','MyGroupTheme','MyGroupTheme',__TEXT__,__WRAP__,__CENTER__);
		$obj_lisha_tran->define_attribute('__column_display_mode',false,'MyGroupTheme');
		$obj_lisha_tran->define_attribute('__column_input_check_update', __FORBIDDEN__,'MyGroupTheme');
		//==================================================================

	//==================================================================



	// Table columns primary key
	// Caution : Can't change key column name from origine query column name
	// It's not required to declare column key with define_column method
	$obj_lisha_tran->define_key(Array('index'));

	//==================================================================
	// Define extra events actions 
	//==================================================================
	//$obj_lisha_tran->define_lisha_action(__ON_ADD__,__AFTER__,'lisha_transaction',Array('rebuild_account();'));
	//==================================================================

	//==================================================================
	// Column order : Define in ascending priority means first line defined will be first priority column to order by and so on...
	//==================================================================
	$obj_lisha_tran->define_order_column('index',__DESC__);					
	$obj_lisha_tran->define_order_column('description',__DESC__);
	$obj_lisha_tran->define_order_column('amount',__ASC__);
	//==================================================================

	//==================================================================
	// Line theme mask
	//==================================================================
	// Default group
	$obj_lisha_tran->define_line_theme("fedddd","0.7em","eecdcd","0.7em","AAAAAA","0.7em","BBBBBB","0.7em","000","000");
	$obj_lisha_tran->define_line_theme("dbaa99","0.7em","db9988","0.7em","EECCCC","0.7em","DDC8C8","0.7em","000","000");

	// Group 2
	//$obj_lisha_tran->define_line_theme("DDEEDD","0.7em","CCEECC","0.7em","68B7E0","0.7em","68B7E0","0.7em","000","000",1);
	//$obj_lisha_tran->define_line_theme("EEFFEE","0.7em","D0E0DC","0.7em","AEE068","0.7em","AEE068","0.7em","000","000",1);

	// Group 3
	//$obj_lisha_tran->define_line_theme("DDDDEE","0.7em","CCCCEE","0.7em","68B7E0","0.7em","68B7E0","0.7em","028","000",2);
	//$obj_lisha_tran->define_line_theme("EEEEFF","0.7em","D0DCE0","0.7em","AEE068","0.7em","AEE068","0.7em","006","000",2);
	//==================================================================			




	//==================================================================
	// Do not remove this bloc
	// Keep this bloc at the end
	//==================================================================
	$obj_lisha_tran->generate_public_header();   
	$obj_lisha_tran->generate_header();
	//==================================================================