<!--заготовки для сортировки страниц по всяким параметрм-->
		
				<div style="display: inline-block; color: black; font-weight: 650;">
			Фильтр:
			<select onchange="top.location=this.value">
				<option></option>
				<option value="/?action=showlist">Сброс</option>
				<option value="<? echo $_SERVER['REQUEST_URI'].'&cond=not_preprinted'; ?>"	>Не подготовлены</option>
				<option value="<? echo $_SERVER['REQUEST_URI'].'&cond=not_printed'; ?>"		>Не отпечатаны	</option>
				<option value="<? /*echo $_SERVER['REQUEST_URI'].'&cond=with_reorder';*/ ?>"	>С перезаказами (еще не работает)	</option>
				
			</select>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		</div>
		<!--<? echo $_SERVER['REQUEST_URI']; ?>-->
		<!--Эта штука пока что не работает - можете не тыкать +)-->