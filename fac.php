<?php

$output = '<span style="width: 96%; height: 100%; float: right; margin: 0px 2%; overflow-x: hidden; overflow-y: scroll;">
						<span style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 12%; width: 100%; float: right; border-bottom: 2px solid #F4F4F4;">
								<span style="margin-top: 2.5%; height: 100%; width: 100%; float: left;">
									<span class="topic_stat">
										<img class="add_forum" src="add_forum.png" height=30 width=30 title="add topic">
									</span>
									<img style="float: right;" src="faculty_whole.png" height=50 width=50></span>
						</span>
						<span class="aff" style="font-family: Calibri; font-size: 30px; color: #404B5C; height: 29%; width: 100%; float: right;" hidden>
							<form method="POST" id="submitfac" action="upfa.php">
								<input class="topic_title" name="topic_title" placeholder="Topic title:" required>
								<span style="width: 10%; float: right; overflow: hidden; cursor: pointer;  display: inline; margin-top: -20px;">
									<label class="isset" for="ff">
										<img style="float: right;" src="empty_attach.png"  height="23" width="23" title="attach file" />
									</label>
									<input type="file" style="display: none;" name="file" id="ff" accept=".pdf" />
								</span>
								<textarea class="topic_desc" id="txta" name="topic_desc" placeholder="Topic description:" required></textarea>
							</form>
						</span>
						<span style="height: 88%; width: 100%; float: right">
							<span style="height: 6%; width: 100%; float: left;">
								<table style="text-align: left; font-family: Calibri; width: 100%;">
									<tr><td style="width:65%; color: #429AA4; font-size: 16px; font-weight: bold;">Topics</td>
										<td style="width:15%; color: #429AA4; font-size: 16px; font-weight: bold;">Replies</td>
										<td style="width:20%; color: #429AA4; font-size: 16px; font-weight: bold;">Freshness</td>
									</tr>
								</table>
							</span>
							<span class="faculty_content">
								<table style="text-align: left; font-family: Calibri; width: 100%;">
									<tr><td style="width:65%; color: #429AA4; font-size: 16px;">Coventry level 6 examination pdf</td>
										<td style="width:15%; color: gray; font-size: 14px; ">5</td>
										<td style="width:20%; color: gray; font-size: 14px;">5 minutes ago</td>
									</tr>
								</table>
							</span>
						</span>
					</span>';

?>