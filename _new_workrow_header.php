<html>
    <head>
    <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
    <style>
        body {
            background-color: rgb(237, 238, 240);
            font-family: Tahoma;
        }
        .mainWrapper {
            display: flex;
            flex-direction: row;
            background-color: #e9e9e9;
        }
        .wrWrapper {
            font-family: Tahoma;
            width: 632px;
            margin: 5px 0px 5px 5px;
            display: flex;
            padding: 2px;
            /*background-color: gray;*/
            flex-direction: column;
            align-content: flex-start;
            align-items: flex-start;
            flex-wrap: wrap;
        }
        .rowWrapper {
            
            display: flex;
            flex-direction: row;
        }
        .rowElement {
          
           display: flex;
        }
        .rowElement * {
            padding: 3px;
            border-radius: 0px;
            border:1px solid gray;
        }
         *:focus{
            box-shadow:0 1px 5px #555;
            background-color: #ffffef;
            outline: 0px;
        }
        .workName textarea {
            height: 30px;
            resize: none;
            width: 203px;
            font-size: 16px;
            font-weight: bold;
        }
        

        .workFormat select{
            height: 30px;
            width: 43px;
        }
        .workWidth input{
            width: 37px;
            height: 30px;
        }
        .workHeight input{
            width: 38px;
            height: 30px;
        }
        .rowWrapper.spacer{
            
        }
        .workColor select{
            height: 30px;
            width: 55px;
            
        }
        .workTech select {
            height: 30px;
            width: 100px;
        }
        .workDescription textarea{
            height: 39px;
            width: 303px;
        }
        .workPostprint textarea{
            height: 39px;
            width: 275px;
        }
        .workMedia select {
            height: 30px;
            width: 160px;
        }
        .workRasklad textarea{
            pointer-events: none;
            width: 58px;
            height: 39px;
            resize: none;
        }
        .priceBlock {
            margin-top: 5px;
            padding-top: 2px;
            padding-left: 0px;
            margin-left: 5px;
            height: 71px;
            width: 200px;
        }
        .priceBlock_firstrow input {
            width: 65px;
            height: 30px;
        }
        .priceBlock_secondrow input {
            width: 65px;
            height: 39px;
        }
        .priceBlock_secondrow select {
            width: 130px;
            height: 39px;
        }
        .rowElement_priceblock {
            float: left;
            margin-right: 0px;
        }
        .orderInfoWrapper {
            display: flex;
            flex-direction: row;
        }
        .mainInfo_manager textarea {
            pointer-events: none;
            font-size: 20px;
            text-align: center;
            line-height: 28px;
            font-weight: bold;
            width: 45px;
        }

        .mainInfo_number textarea {
            pointer-events: none;
            font-size: 20px;
            text-align: center;
            line-height: 28px;
            font-weight: bold;
            width: 85px;
        }
        .mainInfo_description textarea {
            font-size: 20px;
            text-align: left;
            line-height: 28px;
            width: 700px;


        }

        .mainInfo textarea {
            border-radius: 0px;
            resize: none;
            height: 36px;
            
        }
        
        .orderInfoPart {
            display: flex;
            flex-direction: column;
        }
        .verticalBlock {
            padding-right: 15px;
            padding-bottom: 15px;
            display: flex;
            flex-direction: column;
        }
        .contragentInformation {
           

            border: 1px solid black;
            
        }
        .statusInformation {
            margin-left: 5px;
            width: 250px;
            height: 400px;
            border: 1px solid black;
            
        }
        .connectivityInformation {
            margin-left: 5px;
            width: 250px;
            height: 400px;
            border: 1px solid black;
            
        }
        .orderInfoWrapper__verticalBlocks {
            margin-top: 10px;
            min-width: 1000px;
        }
        .verticalBlock {
            box-shadow:  rgb(165 , 165, 165) 0px 0px 1px 0px;
            background-color: white;
            border: none;
            border-radius: 3px;
        }
        .contragentInformation_element {
            /*padding: 5px;*/
            margin-left: 10px;
        }
        .contragentInformation_element input, .contragentInformation_element textarea {
            height: 25px;
            font-size: 14px;
            border-radius: 3px;
            border: none;
            box-shadow:  rgb(0 , 0, 0) 0px 0px 1px 0px;
            margin-top: 15px;
           
        }
        .contragentInformation_element-shortName {
            margin-top: 5px;
        }
        .contragentInformation_element-shortName input{
            width: 350px;
        }
        .input_desc {
            position: absolute;
            font-size: 12px;
            margin-left: 10px;
            color: #333;
        }
        .contragentInformation_element-fullReq textarea{
            width: 400px;
            height: 75px;
        }
        .contragentInformation_element-contacts textarea{
            width: 400px;
            height: 75px;
        }
        .contragentInformation_element-dopinfo textarea{
            width: 400px;
            height: 75px;
        }
    </style>
    </head>
    
    <body>
<div class="orderInfoPart">
    
    <div class="orderInfoWrapper">
        <div class="mainInfo mainInfo_manager"><textarea>Ю</textarea></div>
        <div class="mainInfo mainInfo_number" ><textarea>12344</textarea></div>
        <div class="mainInfo mainInfo_description"><textarea placeholder="описание заказа"></textarea></div>
    </div>

    <div class="orderInfoWrapper orderInfoWrapper__verticalBlocks">
        <div class="verticalBlock contragentInformation">
            <div class="contragentInformation_element contragentInformation_element-shortName"><div class="input_desc">Заказчик</div><input></div>
            <div class="contragentInformation_element contragentInformation_element-waNumber"><div class="input_desc">телефон для WhatsApp</div><input></div>
            <div class="contragentInformation_element contragentInformation_element-inn"><div class="input_desc">ИНН</div><input></div>
            <div class="contragentInformation_element contragentInformation_element-contacts"><div class="input_desc">Контактные данные</div><textarea></textarea></div>
            <div class="contragentInformation_element contragentInformation_element-fullReq"><div class="input_desc">Полные реквизиты</div><textarea></textarea></div>
            <div class="contragentInformation_element contragentInformation_element-dopinfo"><div class="input_desc">Дополнтильная информация</div><textarea></textarea></div>
            

        </div>
        <div class="verticalBlock statusInformation">sss</div>
        <div class="verticalBlock connectivityInformation">sss</div>
    </div>








</div>


<div class="tablePart">
    <div class="mainWrapper">    
        <div class="wrWrapper">
            <div class="rowWrapper firstRow">
                <div class="rowElement  workName"><textarea>Название</textarea></div>
                <div class="rowElement  workTech"><select>
                                                    <option>  XEROX   </option>
                                                    <option>content</option>
                                                    <option>content</option>
                                                </select>
                </div>
                <div class="rowElement  workColor"><select>
                                                    <option>4+4</option>
                                                    <option>4+0</option>
                                                    <option>1+0</option>
                                                </select>
                </div>
                <div class="rowElement  workFormat"><select>
                                                    <option>A1</option>
                                                    <option>A2</option>
                                                    <option>A3</option>
                                                    </select>
                </div>
                <div class="rowElement  workWidth"><input></div>
                <div class="rowElement  workHeight"><input></div>
                <div class="rowElement  workMedia"><select>
                                                    <option>Тач слон кость</option>
                                                    <option>A2</option>
                                                    <option>A3</option>
                                                    </select>
                </div>
                

            </div>
            
            <div class="rowWrapper spacer"></div>
            
            <div class="rowWrapper secondRow">
                <div class="rowElement  workDescription"><textarea>описание дополнительное </textarea></div>
                <div class="rowElement  workPostprint"><textarea>постпечатка </textarea></div>
                <div class="rowElement  workRasklad"><textarea></textarea></div>
                

            </div>
            
 
        </div>

        <div class="wrWrapper">
            <div class="priceBlock priceBlock_firstrow">
                <div class="rowElement rowElement_priceblock priceBlock_firstrow"><input placeholder="кол."></div>
                <div class="rowElement rowElement_priceblock priceBlock_firstrow"><input placeholder="цена"></div>
                <div class="rowElement rowElement_priceblock priceBlock_firstrow"><input placeholder="сумма"></div>
                <div class="rowElement rowElement_priceblock priceBlock_secondrow"><input placeholder="расход"></div>
                <div class="rowElement rowElement_priceblock priceBlock_secondrow"><select><option></option></select></div>
            </div>
        </div>



    </div>    
        <button class="click">Добавить</button>
        <button class="click2">Убавить</button>
</div>
            
        
    <script>
        $( document ).ready(function() {
			$('.click2').on('click', function(){
			$('.mainWrapper:last').remove();
			autocompleteRun();
			});
					
		});

        $( document ).ready(function() {
			/*onclick(document.getElementById("delete_button").remove());*/
			
			$('.click').on('click', function(){
			/*$('.delete_button').remove();*/
			$(this).before($(".mainWrapper:last").clone());
			$(".mainWrapper:last .autoClear").find('input').val("");
			/*$(".delete_button").find('a').remove();*/
			/*autocompleteRun();*/
			
			/*document.getElementById("delete_button").remove();*/
			});		
		
		});
        
    </script> 
</body>
</html>