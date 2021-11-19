<?php
    $hrefs[0][0] = "/?action=new";
    $hrefs[0][1] = "img/icons/file, data, document, interface, paper.png";
    $hrefs[0][2] = "Новый заказ";

    $hrefs[1][0] = "/?&myorder=0&noready=1&showlist=&delivery=1&manager=current";
    $hrefs[1][1] = "img/icons/newspaper, article, headline, journal, news.png";
    $hrefs[1][2] = "Все заказы";

    $hrefs[2][0] = "/_work_flow.php";
    $hrefs[2][1] = "img/icons/calendar,%20schedule,%20month,%20date,%20event.png";
    $hrefs[2][2] = "График";

    $hrefs[3][0] = "/?action=cashbox&date=".date("Y")."-".date("m")."-".(date("d"));
    $hrefs[3][1] = "img/icons/money, dollar, cash, finance, payment.png";
    $hrefs[3][2] = "Касса";

    $hrefs[4][0] = "/?action=client_list";
    $hrefs[4][1] = "img/icons/user, account, profile, avatar, person.png";
    $hrefs[4][2] = "Клиенты";

    // $hrefs[5][0] = "/?action=showlist&filter=archive";
    // $hrefs[5][1] = "img/icons/drawer, archive, files, documents, office.png";
    // $hrefs[5][2] = "Мой архив";

    // $hrefs[6][0] = "/?action=showlist&filter=archiveoverall";
    // $hrefs[6][1] = "img/icons/database, server, storage, data center, hosting.png";
    // $hrefs[6][2] = "Весь архив";

    $hrefs[5][0] = "/?action=templates";
    $hrefs[5][1] = "img/icons/code, coding, html, css, programming.png";
    $hrefs[5][2] = "Шаблоны";

    $hrefs[6][0] = "/?action=administrating&filter=startscreen";
    $hrefs[6][1] = "img/icons/bug, virus, insect, malware, pest.png";
    $hrefs[6][2] = "Админка";

    $hrefs[7][0] = "/?action=paydemands";
    $hrefs[7][1] = "img/icons/refresh, reload, repeat, sync, rotate.png";
    $hrefs[7][2] = "Поставщики";

    // $hrefs[9][0] = "/?action=showlist&filter=delivery";
    // $hrefs[9][1] = "img/icons/send, paper plane, sent, interface, message.png";
    // $hrefs[9][2] = "Доставка";

    // $hrefs[11][0] = "/?action=showlist&filter=fulllist";
    // $hrefs[11][1] = "img/icons/computer, screen, display, monitor, desktop.png";
    // $hrefs[11][2] = "Полный список";

//счетчик сообщений
$message_query = "SELECT * FROM `messages_chains` WHERE (
																(
																	(`responders` LIKE '%$current_manager%') or (`responders` = 'all')
																)

																and

																(`flag_of_chain_close` = 0)
															)";
$message_array = mysql_query($message_query);
$a = mysql_num_rows($message_array);
$newmessage_flag_sql = "SELECT * FROM `messages_chains`
							LEFT JOIN `users` ON users.word='$current_manager'

							WHERE users.last_visit_messages<messages_chains.date_of_chain_update";
$newmessage_flag_array = mysql_query($newmessage_flag_sql);

/*	echo mysql_num_rows($message_array);*/
if (mysql_num_rows($newmessage_flag_array)==0) {
    $hrefs[8][0] = "/?action=messages&step=start_page";
    $hrefs[8][1] = "img/icons/chat, comment, message, talk, speak.png";
    $hrefs[8][2] = "Сообщения(".$a.")";
}

if (mysql_num_rows($newmessage_flag_array)>0) {
    $hrefs[8][0] = "/?action=messages&step=start_page";
    $hrefs[8][1] = "img/icons/active_message.png";
    $hrefs[8][2] = "Сообщения(".$a.")";
}


?>
