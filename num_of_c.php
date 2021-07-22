<?php

$c = $_POST['c'];
$id =  $_POST['id'];
$output = '';

if($id == '4')
{
	for($i=1; $i <= $c; $i++)
	{
		$output .= '<tr style="width: 50%; display: inline-block;">
						<td style="width: 98%; display: block; margin: 2% 0px; position: relative;">
							<input id='.$i.' type="Text" name="c_'.$i.'" spellcheck="false" class="choice_num" placeholder="Choice '.$i.'" />
							<label class="vset" data-id="'.$i.'" id="fv_'.$i.'" for="vf_'.$i.'">
								<img style="position: absolute; right: 10%; top: 15%;" src="empty_attach.png"  height="23" width="23" title="attach file" />
							</label>
							<input type="file" class="inv" data-id="'.$i.'" style="display: none;" name="via_'.$i.'" id="vf_'.$i.'" accept=".jpg, .png, .gif" />
						</td>
					</tr>';
	}
}
elseif ($id == '10') {
	for($i=1; $i <= $c; $i++)
	{
		$output .= '<tr style="width: 50%; display: inline-block;">
						<td style="width: 98%; display: block; margin: 2% 0px; position: relative;">
							<input id=con_'.$i.' data-id = '.$i.' type="Text" name="c_'.$i.'" spellcheck="false" class="choice_num" placeholder="Contestant '.$i.'" />
							<span id=ser_'.$i.' class="ser" hidden>
							</span>
							<img style="position: absolute; top: 100%; left: 76%; z-index: 2; display: block; cursor: pointer;" height= 12 width = 12 src="hide.png" class="hide_sl" data-id="'.$i.'" id="hsl_'.$i.'" >
						</td>
					</tr>';
	}
}
echo $output;

?>