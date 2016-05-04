<?php // content="text/plain; charset=utf-8"
require 'conf.php';
require 'config/config_foot.php';
require 'lib/lib_gen.php';
require 'lib_foot.php';
require 'lib/lib_jpgraph.php';
require_once ('lib/jpgraph/src/jpgraph.php');
require_once ('lib/jpgraph/src/jpgraph_line.php');
require_once ('lib/jpgraph/src/jpgraph_mgraph.php');
require 'class/autoload.php';
$DB = DB::Open();
$matches_played=matches_played();
$x_axis_length=floor(400+$matches_played*300/$last_match);
//echo "x:".$x_axis_length;
//new graph
$graph = new Graph($x_axis_length,400);
//$graph = new Graph(550,350);
$graph->SetScale('textlin');
$match_labels=make_array_matches_graph();
//count matches played and compute label angle
$angle=floor(90*$matches_played/$last_match);
// Some data
$i=0;
$last=sizeof($plot_mark);
while(list($key,$val)=each($_REQUEST)){
//	if($key!='Submit'){
		$ydata=make_array_point_id($val);
		// Create the linear plot
		$lineplot=new_line($ydata,$plot_mark[$i],$val,$plot_mark[$i]);
		// Add the plot to the graph
		$graph->Add($lineplot);
		unset($lineplot);
		$i+=1;
		if($i>=$last) $i=0;
//	}	
}

//add labels for the x-axis
//set the legend
$graph->legend->SetPos(0,0);
//$graph->xaxis->SetLabelAngle(45)
$graph->xaxis->SetFont(FF_DV_SANSSERIF,FS_NORMAL,7); 
$graph->xaxis->SetLabelAngle($angle);
$graph->xaxis->SetTickLabels($match_labels);
//add background image
// Display the graph
//-----------------------
// Create a multigraph
//----------------------
$mgraph = new MGraph();
$mgraph->SetBackgroundImage('img/uefatrophy.jpg');
$mgraph->SetImgFormat('jpeg',60);
$mgraph->SetMargin(2,2,2,2);
$mgraph->SetFrame(true,'darkgray',2);
$mgraph->AddMix($graph,0,0,50);
//$mgraph->Stroke();
$graph->Stroke();
?>
