<html>
    <head>
    <SCRIPT type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></SCRIPT>
    <style>
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
        .rowElement *:focus{
            box-shadow:0 0 10px #555;
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
            width: 39px;
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
            width: 54px;
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

    </style>
    </head>
    
    <body>
<div class="orderInfoPart">
        asda
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

        <div class="rWrapper">
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