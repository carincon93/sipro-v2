<script>
    import Loading from './Loading.svelte'

    export let items

    let loading = false

    function initChart() {
        google.charts.load('current', {'packages':['gantt'], 'language': 'es'})
        google.charts.setOnLoadCallback(drawChart)
    }

    function drawChart() {
        var data = new google.visualization.DataTable()
        data.addColumn('string', 'Task ID')
        data.addColumn('string', 'Task Name')
        data.addColumn('date', 'Start Date')
        data.addColumn('date', 'End Date')
        data.addColumn('number', 'Duration')
        data.addColumn('number', 'Percent Complete')
        data.addColumn('string', 'Dependencies')

        items.map(function(item) {
            data.addRows([
                [
                    'itemID-'+item.id,
                    '',
                    new Date(item.start_year, item.start_month - 1, item.start_day),
                    new Date(item.end_year, item.end_month - 1, item.end_day),
                    null,
                    100,
                    null
                ],
            ])
        })

        let trackHeight = 120

        var options = {
            width: '100%',
            backgroundColor: {
                fill: 'white',
            },
            height: (items.length + 1) * trackHeight,
            gantt: {
                trackHeight: trackHeight,
                labelMaxWidth: 0,
                labelStyle: {
                fontName: "'Nunito', sans-serif",
                fontSize: 10,
                color: '#757575',
                }
            },
            backgroundColor: {
                fill: '#fff'
            }
        }

        // Valida si el document.getElementById('chart_div') existe para proceder a dibujar el GanttChart
        if (typeof(document.getElementById('chart_div')) != 'undefined' && document.getElementById('chart_div') != null) {
            var chart = new google.visualization.Gantt(document.getElementById('chart_div'))

            loading = true

            chart.draw(data, options)

            google.visualization.events.addListener(chart, 'select', handleClick)

            function handleClick(){
                var selection = chart.getSelection();
                for (var i = 0; i < selection.length; i++) {
                    var item    = selection[i]
                    var itemID  = data.getValue(item.row, i)
                    let er      = /(\w{6}-)/
                    let newID   = itemID.replace(er, '')

                    console.log(newID);
                }
            }
        }
    }
</script>

<svelte:head>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js" on:load={initChart}></script>
</svelte:head>

<div class="flex relative">
    <aside class="labels" style="overflow: auto; {items.length > 0 ? 'flex: 0.5' : ''}">
        <ul class="list-unstyled">
            {#each items as item}
                <li style="height: 120px; padding: 7px;line-height: 1.2;display: flex;justify-content: space-between;width: 100%;">
                    <span style="max-width: 90%;max-height: 50px;overflow: hidden;">{item.description}</span>
                </li>
            {/each}
        </ul>
    </aside>
    <div id="chart_div" style="flex: 1;"></div>
    <Loading {loading} bg="transparent"/>
</div>

