<?php
require '../admin/config.php';
include '../admin/html/header.php';
//https://console.developers.google.com/apis/credentials
?>
 
<div id="embed-api-auth-container"></div>
<div id="view-selector-container" style="display:none;"></div> 
 

<h3>Nombre de sessions</h3>
<h4>Entre <span style="color:#C2D4DD;"><?php echo date("Y"); ?></span> et <span style="color:#EEEEEE;"><?php echo (date("Y")-1); ?></span></h4>
<div id="chart-2-container"></div> 

<h3>Nombre de pages vues</h3>
<h4>Entre <span style="color:#C2D4DD;"><?php echo date("Y"); ?></span> et <span style="color:#EEEEEE;"><?php echo (date("Y")-1); ?></span></h4>
<div id="chart-6-container"></div> 

<h3>Sur 2 semaines</h3>
<h4>Détails par jour</h4>
<div id="chart-1-container"></div> 


<h3>Pages les plus vues</h3>
<h4>Au cours des 30 derniers jours</h4>
<div id="legend-3-container" style="width:50%;float:left;"></div>
<div id="chart-3-container" style="width:50%;float:right;"></div>

<p class="clear"></p>
 
<script>
(function(w,d,s,g,js,fs){
  g=w.gapi||(w.gapi={});g.analytics={q:[],ready:function(f){this.q.push(f);}};
  js=d.createElement(s);fs=d.getElementsByTagName(s)[0];
  js.src='https://apis.google.com/js/platform.js';
  fs.parentNode.insertBefore(js,fs);js.onload=function(){g.load('analytics');};
}(window,document,'script'));
</script>
  
 
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/1.0.2/Chart.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/admin-view-selector2.js"></script>
<script src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/admin-date-range-selector.js"></script>
<script src="//<?php echo $_SERVER['SERVER_NAME']; ?>/ressources/js/admin-active-users.js"></script>

 
<script>
gapi.analytics.ready(function() {

	// PARAMETRES A MODIFIER EN FONCYION DES COMPTES GOOGLE
	var CLIENT_ID = 'XXXXXXXXXXXXX-XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX.apps.googleusercontent.com';
	var COMPTE = 'ga:XXXXXXXXX';

  gapi.analytics.auth.authorize({
 
	 container: 'embed-api-auth-container',
     clientid: CLIENT_ID,
	 userInfoLabel: 'Vous êtes connecté en tant que : ' 
  });

  
    renderYearOverYearChart('ga:XXXXXXXXX');
    renderPagesOverYearChart('ga:XXXXXXXXX');
    renderWeekOverWeekChart('ga:XXXXXXXXX');
    renderTopPagesChart('ga:XXXXXXXXX'); 
 
  var viewSelector = new gapi.analytics.ext.ViewSelector2({
    container: 'view-selector-container',
  })
  .execute();
 
  viewSelector.on('viewChange', function(data) {
	//var title = document.getElementById('view-name');
	//title.innerHTML = 'NOM DU SITE';
	//console.log(data);
	// Toutes les données du site Web 
	// ga:XXXXXXXXX
	// Start tracking active users for this view.
	//activeUsers.set(data).execute();

	// Render all the of charts for this view.
  });

 
  function renderWeekOverWeekChart(ids) {
 
    var now = moment(); // .subtract(3, 'day');

    var thisWeek = query({
      'ids': ids,
      'dimensions': 'ga:date,ga:nthDay',
      'metrics': 'ga:sessions',
      'start-date': moment(now).subtract(1, 'day').day(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD')
    });

    var lastWeek = query({
      'ids': ids,
      'dimensions': 'ga:date,ga:nthDay',
      'metrics': 'ga:sessions',
      'start-date': moment(now).subtract(1, 'day').day(0).subtract(1, 'week')
          .format('YYYY-MM-DD'),
      'end-date': moment(now).subtract(1, 'day').day(6).subtract(1, 'week')
          .format('YYYY-MM-DD')
    });

    Promise.all([thisWeek, lastWeek]).then(function(results) {

      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = results[1].rows.map(function(row) { return +row[0]; });

      labels = labels.map(function(label) {
        return moment(label, 'YYYYMMDD').format('ddd');
      });

      var data = {
        labels : ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'],
        datasets : [
          {
            label: 'Semaine dernière',
            fillColor : 'rgba(220,220,220,0.5)',
            strokeColor : 'rgba(220,220,220,1)',
            pointColor : 'rgba(220,220,220,1)',
            pointStrokeColor : '#fff',
            data : data2
          },
          {
            label: 'Cette semaine',
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            pointColor : 'rgba(151,187,205,1)',
            pointStrokeColor : '#fff',
            data : data1
          }
        ]
      };

      new Chart(makeCanvas('chart-1-container')).Line(data); 
    });
  }
 
  function renderYearOverYearChart(ids) {
 
    var now = moment(); // .subtract(3, 'day');

    var thisYear = query({
      'ids': ids,
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:sessions',
      'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD')
    });

    var lastYear = query({
      'ids': ids,
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:sessions',
      'start-date': moment(now).subtract(1, 'year').date(1).month(0)
          .format('YYYY-MM-DD'),
      'end-date': moment(now).date(1).month(0).subtract(1, 'day')
          .format('YYYY-MM-DD')
    });

    Promise.all([thisYear, lastYear]).then(function(results) {
      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
 
      for (var i = 0, len = labels.length; i < len; i++) {
        if (data1[i] === undefined) data1[i] = null;
        if (data2[i] === undefined) data2[i] = null;
      }

      var data = {
        labels : labels,
        datasets : [
          {
            label: '<?php echo (date("Y")-1); ?>',
            fillColor : 'rgba(220,220,220,0.5)',
            strokeColor : 'rgba(220,220,220,1)',
            data : data2
          },
          {
            label: '<?php echo date("Y"); ?>',
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            data : data1
          }
        ]
      };

      new Chart(makeCanvas('chart-2-container')).Bar(data); 
    })
    .catch(function(err) {
      console.error(err.stack);
    });
  }
  
  function renderPagesOverYearChart(ids) {
 
    var now = moment(); // .subtract(3, 'day');

    var thisYear = query({
      'ids': ids,
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:pageviews',
      'start-date': moment(now).date(1).month(0).format('YYYY-MM-DD'),
      'end-date': moment(now).format('YYYY-MM-DD')
    });

    var lastYear = query({
      'ids': ids,
      'dimensions': 'ga:month,ga:nthMonth',
      'metrics': 'ga:pageviews',
      'start-date': moment(now).subtract(1, 'year').date(1).month(0)
          .format('YYYY-MM-DD'),
      'end-date': moment(now).date(1).month(0).subtract(1, 'day')
          .format('YYYY-MM-DD')
    });

    Promise.all([thisYear, lastYear]).then(function(results) {
      var data1 = results[0].rows.map(function(row) { return +row[2]; });
      var data2 = results[1].rows.map(function(row) { return +row[2]; });
      var labels = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];

      for (var i = 0, len = labels.length; i < len; i++) {
        if (data1[i] === undefined) data1[i] = null;
        if (data2[i] === undefined) data2[i] = null;
      }

      var data = {
        labels : labels,
        datasets : [
          {
            label: '<?php echo (date("Y")-1); ?>',
            fillColor : 'rgba(220,220,220,0.5)',
            strokeColor : 'rgba(220,220,220,1)',
            data : data2
          },
          {
            label: '<?php echo date("Y"); ?>',
            fillColor : 'rgba(151,187,205,0.5)',
            strokeColor : 'rgba(151,187,205,1)',
            data : data1
          }
        ]
      };

      new Chart(makeCanvas('chart-6-container')).Bar(data);
      //generateLegend('legend-6-container', data.datasets);
    })
    .catch(function(err) {
      console.error(err.stack);
    });
  }
 
  function renderTopPagesChart(ids) {

    query({
      'ids': ids,
      'start-date': '30daysAgo',
      'end-date': 'yesterday',
      'metrics': 'ga:pageviews',
      'dimensions': 'ga:pagePathLevel1',
      'sort': '-ga:pageviews',
      'filters': 'ga:pagePathLevel1!=/',
      'max-results': 7
    })
    .then(function(response) {

      var data = [];
      var colors = ['#A9E2F3','#A9BCF5','#BCA9F5','#E2A9F3','#F5A9E1','#F5A9BC','#FA5882'];

      response.rows.forEach(function(row, i) {
        data.push({ value: +row[1], color: colors[i], label: row[0] });
      });

      new Chart(makeCanvas('chart-3-container')).Doughnut(data);
      generateLegend('legend-3-container', data);
    });
  }
 
  function query(params) {
    return new Promise(function(resolve, reject) {
      var data = new gapi.analytics.report.Data({query: params});
      data.once('success', function(response) { resolve(response); })
          .once('error', function(response) { reject(response); })
          .execute();
    });
  }
 
  function makeCanvas(id) {
    var container = document.getElementById(id);
    var canvas = document.createElement('canvas');
    var ctx = canvas.getContext('2d');

    container.innerHTML = '';
    canvas.width = container.offsetWidth;
   // canvas.height = container.offsetHeight;
    container.appendChild(canvas);

    return ctx;
  }
 
  function generateLegend(id, items) {
    var legend = document.getElementById(id);
    legend.innerHTML = items.map(function(item) {
      var color = item.color || item.fillColor;
      var label = item.label;
      return '<p style="color:' + color + ';"><i></i>' + label + '</p>';
    }).join('');
  }


  Chart.defaults.global.animationSteps = 60;
  Chart.defaults.global.animationEasing = 'easeInOutQuart';
  Chart.defaults.global.responsive = true;
  Chart.defaults.global.maintainAspectRatio = false;

});
</script>

<?php 
include '../admin/html/footer.php';
?>