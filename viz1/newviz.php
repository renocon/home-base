
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8">
  <title>Disability Data</title>
        
  <script type="text/javascript" src="dls/d3.js"></script>
  <script type="text/javascript" src="dls/d3.csv.js"></script>
  <script type="text/javascript" src="dls/d3.layout.js"></script>
  <script type="text/javascript" src="dls/pc-veggie.js"></script>

  <script type="text/javascript" src="dls/jquery.js"></script>
  <script type="text/javascript" src="dls/underscore.js"></script>
  <script type="text/javascript" src="dls/backbone.js"></script>

  <script src="dls/jquery-ui-1.8.16.custom.min.js"></script>
  <script type="text/javascript" src="dls/filter.js"></script>
  
  <!-- SlickGrid -->
  <link rel="stylesheet" href="dls/slickgrid/slick.grid.css" type="text/css" media="screen" charset="utf-8" />
  <script src="dls/jquery.event.drag-2.0.min.js"></script>
  <script src="dls/slickgrid/slick.core.js"></script>
  <script src="dls/slickgrid/slick.grid.js"></script>
  <script src="dls/slickgrid/slick.dataview.js"></script>
  <script src="dls/slickgrid/slick.pager.js"></script>
  <script src="dls/grid.js"></script>
  <script src="dls/pie.js"></script>
  <script src="dls/options.js"></script>
  <script src="dls/food-table.js"></script>
  <link rel="stylesheet" href="dls/style.css" type="text/css" charset="utf-8" />
  <?php include_once("gana.php"); ?>
</head>

<body>
<div id="nav">
  <h1>Disability Data</h1>
  <div class="widget right toggle">
    <input type="range" min="0" max="1" value="0.2" step="0.01" name="power" list="powers" id="line_opacity"></input>
   <br/>
    Opacity: <span id="opacity_level">20%</span>
  </div>
  <div><a href="#" id="shadows" class="right toggle">Shadows</a></div>
  <div><a href="#" id="inverted" class="right toggle">Dark</a></div>
  <div><a href="#" id="no_ticks" class="right toggle">Hide Ticks</a></div>
  <p class="intro left clear">
    Disability Data TT
  </p>
</div>
<div id="main">
  <div class="widgets">
    <h3>Per 10 Years in Age</h3>
    <div id="totals" class="widget right">Total Selected<br/></div>
    <div id="pie" class="widget right">Group Breakdown<br/></div>
    <a href="#" id="export_selected" class="button green filter_control">Export</a>
    <a href="#" id="remove_selected" class="button red filter_control">Remove</a>
    <a href="#" id="keep_selected" class="button green filter_control">Keep</a>
    <div id="pager" class="info"></div>
        <div id="legend">
    </div>
  </div>
  <div id="parallel">
  </div>
  <div id="myGrid"></div>
  <script type="text/javascript">
  
  $(function() {
  
    function load(foods,names){
      var dimensions = new Filter();
      var highlighter = new Selector();

      dimensions.set({data: foods });

      var columns = _(names).value();
      var axes = _(columns).without('name', 'group');

      // var foodgroups =
      //   ["Dairy and Egg Products", /*"Spices and Herbs", "Baby Foods",*/ "Fats and Oils",
      //    "Poultry Products", "Soups, Sauces, and Gravies", "Vegetables and Vegetable Products",
      //    "Sausages and Luncheon Meats", "Breakfast Cereals", "Fruits and Fruit Juices",
      //    "Nut and Seed Products", "Beverages", "Finfish and Shellfish Products",
      //    "Legumes and Legume Products", "Baked Products", "Sweets", "Cereal Grains and Pasta",
      //    "Fast Foods", "Meals, Entrees, and Sidedishes", "Snacks", /*"Ethnic Foods",*/ "Restaurant Foods"];
      
      //var foodgroups = ["Age","Locomotion","Reach","Dexterity","Seeing","Hearing","Communication","Intellectual Function"];
      var foodgroups = ["11-20","21-30","31-40","41-50","51-60","61-70","71-80","91-100"];
      var colors = {
        // "Age" : '#ff7f0e',
        // "Locomotion" : '#aec7e8',
        // "Reach" : '#555',
        // "Dexterity" : '#ffbb78',
        // "Seeing" : '#d62728',
        // "Hearing" : '#98df8a',
        // "Communication" : '#2ca02c',
        // "Intellectual Function" : '#ff9896'//,

        //"1-10" : "#ff7f0e",
        "11-20": "#aec7e8",
        "21-30": "#555",
        "31-40": "#ffbb78",
        "41-50": "#d62728",
        "51-60": "#98df8a",
        "61-70": "#2ca02c",
        "71-80": "#2ca02c",
        "91-100": "#ff9896"

        // "Breakfast Cereals" : '#9467bd',
        // "Fruits and Fruit Juices" : '#c5b0d5',
        // "Nut and Seed Products" : '#8c564b',
        // "Beverages" : '#c49c94',
        // "Finfish and Shellfish Products" : '#e377c2',
        // "Legumes and Legume Products" : '#f7b6d2',
        // "Baked Products" : '#7f7f7f',
        // "Sweets" : '#c7c7c7',
        // "Cereal Grains and Pasta" : ' #bcbd22',
        // "Fast Foods" : '#dbdb8d',
        // "Meals, Entrees, and Sidedishes" : '#17becf',
        // "Snacks" : '#9edae5',
        // "Ethnic Foods" : '#e7ba52',
        // "Restaurant Foods" : '#1f77b4'
      }
      
      _(foodgroups).each(function(group) {
        $('#legend').append("<div class='item'><div class='color' style='background: " + colors[group] + "';></div><div class='key'>" + group + "</div></div>");
      });

      var pc = parallel(dimensions, colors);
      var pie = piegroups(foods, foodgroups, colors, 'group');
      var totals = pietotals(
        ['in', 'out'],
        [_(foods).size(), 0]
      );

      var slicky = new grid({
        model: dimensions,
        selector: highlighter,
        width: $('body').width(),
        columns: columns
      });
      
      // vertical full screen
      var parallel_height = $(window).height() - 64 - 12 - 120 - 320;
      if (parallel_height < 120) parallel_height = 120;  // min height
      if (parallel_height > 340) parallel_height = 340;  // max height
      $('#parallel').css({
          height: parallel_height + 'px',
          width: $(window).width() + 'px'
      });
      
      slicky.update();
      pc.render();

      dimensions.bind('change:filtered', function() {
        var data = dimensions.get('data');
        var filtered = dimensions.get('filtered');
        var data_size = _(data).size();
        var filtered_size = _(filtered).size();
        pie.update(filtered);
        totals.update([filtered_size, data_size - filtered_size]);
        
        var opacity = _([2/Math.pow(filtered_size,0.37), 100]).min();
        $('#line_opacity').val(opacity).change();
      });
      
      highlighter.bind('change:selected', function() {
        var highlighted = this.get('selected');
        pc.highlight(highlighted);
      });

      $('#remove_selected').click(function() {
        dimensions.outliers();
        pc.update(dimensions.get('data'));
        pc.render();
        dimensions.trigger('change:filtered');
        return false;
      });
      
      $('#keep_selected').click(function() {
        dimensions.inliers();
        pc.update(dimensions.get('data'));
        pc.render();
        dimensions.trigger('change:filtered');
        return false;
      });
      
      $('#export_selected').click(function() {
        var data = dimensions.get('filtered');
        var keys = _.keys(data[0]);
        var csv = _(keys).map(function(d) { return '"' + addslashes(d) + '"'; }).join(",");
        _(data).each(function(row) {
          csv += "\n";
          csv += _(keys).map(function(k) {
            var val = row[k];
            if (_.isString(val)) {
              return '"' + addslashes(val) + '"';
            }
            if (_.isNumber(val)) {
              return val;
            }
            if (_.isNull(val)) {
              return "";
            }
          }).join(",");
        });
        var uriContent = "data:application/octet-stream," + encodeURIComponent(csv);
        console.log(csv);
        var myWindow = window.open(uriContent, "Nutrient CSV");
        myWindow.focus();
        return false;
      });

      $('#line_opacity').change(function() {
        var val = $(this).val();
        $('#parallel .foreground path').css('stroke-opacity', val.toString());
        $('#opacity_level').html((Math.round(val*10000)/100) + "%");
      });
      
      $('#parallel').resize(function() {
        // vertical full screen
        pc.render();
        var val = $('#line_opacity').val();
        $('#parallel .foreground path').css('stroke-opacity', val.toString());
      });
      
      $('#parallel').resizable({
        handles: 's',
        resize: function () { return false; }
      });
      
      $('#myGrid').resizable({
        handles: 's'
      });

      function addslashes( str ) {
        return (str+'')
          .replace(/\"/g, "\"\"")        // escape double quotes
          .replace(/\0/g, "\\0");        // replace nulls with 0
      };
      }

      $(document).ready(function(){



      var request = $.ajax({
            type: 'GET',
            url: "getdata.php",
            dataType: 'json',
            success: function(data) {
                 load(data.data,data.names);          

             },
          error: function(jqXHR, textStatus, errorThrown) {
               
                }
          });

        $.ajax(request);
  
  });

    });

  

  </script>
  <!--
    <p>
     Copyright 2011, Kai Chang
    </p>
    <p>
     Licensed under the Apache License, Version 2.0 (the "License");
     you may not use this file except in compliance with the License.
     You may obtain a copy of the License at
    </p>
    <p>
         http://www.apache.org/licenses/LICENSE-2.0
    </p>
    <p>
     Unless required by applicable law or agreed to in writing, software
     distributed under the License is distributed on an "AS IS" BASIS,
     WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
     See the License for the specific language governing permissions and
     limitations under the License.
  -->
</div>
</body>
</html>
