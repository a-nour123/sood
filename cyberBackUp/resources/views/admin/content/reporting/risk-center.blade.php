@extends('admin/layouts/contentLayoutMaster')

@section('title', __('report.Overview'))
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection
@section('page-style')
    <style>
        * {
            box-sizing: border-box;
        }

        .container {
            background: rgba(255, 255, 255, 0.98);
            border-radius: 20px;
            padding: 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.12);
            backdrop-filter: blur(16px);
            margin-bottom: 40px;
            border: 2px solid #e8eaf6;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .container:hover {
            box-shadow: 0 24px 80px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .title {
            text-align: center;
            color: #2d3436;
            margin-bottom: 35px;
            font-size: 2.5em;
            font-weight: 600;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 18px;
            margin-bottom: 35px;
            flex-wrap: wrap;
            align-items: center;
        }

        .btn {
            padding: 13px 28px;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.3);
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }

        .btn:hover::before {
            width: 300px;
            height: 300px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }

        .btn-success {
            background: linear-gradient(135deg, #00b894 0%, #00cec9 100%);
            color: white;
        }

        .btn-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.2);
        }

        .btn:active {
            transform: translateY(-1px);
        }

        .filter-group {
            display: flex;
            gap: 12px;
            align-items: center;
            background: rgba(255, 255, 255, 0.95);
            padding: 12px 24px;
            border-radius: 25px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
            border: 2px solid #e8eaf6;
            transition: all 0.3s ease;
        }

        .filter-group:hover {
            border-color: #667eea;
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.15);
        }

        .filter-group label {
            font-weight: 600;
            color: #667eea;
            margin: 0;
            font-size: 13px;
        }

        .filter-checkbox {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #667eea;
        }

        #graph-container {
            width: 100%;
            height: 750px;
            border: 2px solid #e8eaf6;
            border-radius: 16px;
            overflow: hidden;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            position: relative;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .node {
            cursor: grab;
            transition: all 0.2s ease;
        }

        .node:active {
            cursor: grabbing;
        }

        .node circle {
            stroke: #fff;
            stroke-width: 3px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
            transition: all 0.3s ease;
        }

        .node:hover circle {
            stroke-width: 5px;
            filter: drop-shadow(0 8px 16px rgba(0, 0, 0, 0.35));
            transform: scale(1.15);
        }

        .node.dimmed circle {
            opacity: 0.2;
        }

        .node text {
            font-weight: 600;
            font-size: 12px;
            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.9);
            pointer-events: none;
            user-select: none;
            transition: all 0.3s ease;
        }

        .node:hover text {
            font-size: 13px;
            font-weight: 700;
        }

        .link {
            stroke: #999;
            stroke-opacity: 0.35;
            stroke-width: 2px;
            fill: none;
            transition: all 0.3s ease;
        }

        .link.highlighted {
            stroke: #667eea;
            stroke-opacity: 1;
            stroke-width: 4px;
            animation: pulse 1.5s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { stroke-opacity: 1; }
            50% { stroke-opacity: 0.6; }
        }

        .link.dimmed {
            stroke-opacity: 0.05;
        }

        .tooltip {
            position: absolute;
            background: linear-gradient(135deg, #1e272e 0%, #2d3436 100%);
            color: #fff;
            padding: 24px 28px;
            border-radius: 18px;
            font-size: 14px;
            line-height: 1.8;
            box-shadow: 0 16px 48px rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(16px);
            max-width: 420px;
            z-index: 1000;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid #4facfe;
            transform: translateY(10px) scale(0.95);
        }

        .tooltip.show {
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .tooltip-title {
            font-weight: 700;
            font-size: 19px;
            margin-bottom: 16px;
            color: #4facfe;
            letter-spacing: 0.3px;
            border-bottom: 2px solid rgba(79, 172, 254, 0.3);
            padding-bottom: 10px;
        }

        .tooltip-section {
            margin-bottom: 10px;
            padding: 8px 0;
        }

        .tooltip-section:last-child {
            margin-bottom: 0;
        }

        .tooltip-label {
            font-weight: 700;
            color: #f093fb;
            display: inline-block;
            min-width: 130px;
        }

        .risk-indicator {
            display: inline-block;
            width: 18px;
            height: 18px;
            border-radius: 4px;
            margin-left: 10px;
            vertical-align: middle;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
        }

        .legend {
            position: absolute;
            top: 15px;
            right: 15px;
            background: rgba(255, 255, 255, 0.98);
            padding: 20px;
            border-radius: 14px;
            font-size: 13px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            max-height: 500px;
            overflow-y: auto;
            border: 2px solid #e8eaf6;
            backdrop-filter: blur(10px);
        }

        .legend::-webkit-scrollbar {
            width: 6px;
        }

        .legend::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .legend::-webkit-scrollbar-thumb {
            background: #667eea;
            border-radius: 10px;
        }

        .legend-title {
            font-weight: 700;
            font-size: 16px;
            margin-bottom: 14px;
            color: #667eea;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
            transition: all 0.2s ease;
            padding: 4px;
            border-radius: 6px;
        }

        .legend-item:hover {
            background: rgba(102, 126, 234, 0.1);
            transform: translateX(3px);
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 12px;
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .zoom-controls {
            position: absolute;
            bottom: 25px;
            right: 25px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .zoom-btn {
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.98);
            border: 2px solid #667eea;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 700;
            color: #667eea;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .zoom-btn:hover {
            background: #667eea;
            color: white;
            transform: scale(1.15);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
        }

        .zoom-btn:active {
            transform: scale(1.05);
        }

        .stats-panel {
            background: rgba(255, 255, 255, 0.98);
            padding: 24px;
            border-radius: 16px;
            margin-top: 30px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 24px;
            border: 2px solid #e8eaf6;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            border-radius: 12px;
            background: linear-gradient(135deg, #f5f7fa 0%, #e8eaf6 100%);
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.2);
            border-color: #667eea;
        }

        .stat-number {
            font-size: 36px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .stat-label {
            font-size: 13px;
            color: #636e72;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .search-box {
            padding: 12px 24px;
            border: 2px solid #667eea;
            border-radius: 30px;
            font-size: 14px;
            width: 280px;
            outline: none;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.95);
            font-weight: 500;
        }

        .search-box:focus {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.4);
            border-color: #764ba2;
            background: white;
        }

        .search-box::placeholder {
            color: #b2bec3;
        }

        .mode-indicator {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(255, 255, 255, 0.95);
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 12px;
            font-weight: 600;
            color: #667eea;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #e8eaf6;
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 100;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }

        .loading-overlay.active {
            opacity: 1;
            pointer-events: all;
        }

        .spinner {
            width: 50px;
            height: 50px;
            border: 4px solid #e8eaf6;
            border-top-color: #667eea;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    <div class="content-header row">
        <div class="content-header-left col-12 mb-2">
            <div class="row breadcrumbs-top widget-grid">
                <div class="col-12">
                    <div class="page-title mt-2">
                        <div class="row">
                            <div class="col-sm-6 ps-0">
                                @if (@isset($breadcrumbs))
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a href="{{ route('admin.dashboard') }}" style="display: flex;">
                                                <svg class="stroke-icon">
                                                    <use href="{{ asset('fonts/icons/icon-sprite.svg#stroke-home') }}"></use>
                                                </svg>
                                            </a>
                                        </li>
                                        @foreach ($breadcrumbs as $breadcrumb)
                                            <li class="breadcrumb-item">
                                                @if (isset($breadcrumb['link']))
                                                    <a href="{{ $breadcrumb['link'] == 'javascript:void(0)' ? $breadcrumb['link'] : url($breadcrumb['link']) }}">
                                                @endif
                                                {{ $breadcrumb['name'] }}
                                                @if (isset($breadcrumb['link']))
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ol>
                                @endisset
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="fluid-container">
        <h1 class="title">Risk Analysis</h1>
        
        <div class="controls">
            <input type="text" id="search-input" class="search-box" placeholder="🔍 Search nodes...">
            
            <div class="filter-group">
                <label>Show:</label>
                <label><input type="checkbox" class="filter-checkbox" data-type="risk" checked> Risks</label>
                <label><input type="checkbox" class="filter-checkbox" data-type="asset" checked> Assets</label>
                <label><input type="checkbox" class="filter-checkbox" data-type="control" checked> Controls</label>
                <label><input type="checkbox" class="filter-checkbox" data-type="exception" checked> Exceptions</label>
                <label><input type="checkbox" class="filter-checkbox" data-type="threat" checked> Threats</label>
            </div>

            <button class="btn btn-primary" onclick="resetSimulation()">🔄 Reset Layout</button>
            <button class="btn btn-secondary" onclick="togglePhysics()">⚡ <span id="physics-text">Disable</span> Physics</button>
            <button class="btn btn-success" onclick="fitToScreen()">📐 Fit to Screen</button>
            <button class="btn btn-info" onclick="centerGraph()">🎯 Center Graph</button>
        </div>

        <div id="graph-container">
            <div class="mode-indicator" id="mode-indicator">⚡ Physics: Active</div>
            
            <div class="loading-overlay" id="loading">
                <div class="spinner"></div>
            </div>

            <div class="legend">
                <div class="legend-title">📊 Legend</div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #4facfe;"></div>
                    <span>Center</span>
                </div>
                @foreach ($riskLevels as $level)
                    <div class="legend-item">
                        <div class="legend-color" style="background: {{ $level->color }};"></div>
                        <span>{{ ucfirst($level->name) }} Risk</span>
                    </div>
                @endforeach
                <div class="legend-item">
                    <div class="legend-color" style="background: #00b894;"></div>
                    <span>Asset</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #0984e3;"></div>
                    <span>Control</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #fdcb6e;"></div>
                    <span>Exception</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background: #e17055;"></div>
                    <span>Threat</span>
                </div>
            </div>

            <div class="zoom-controls">
                <button class="zoom-btn" onclick="zoomIn()" title="Zoom In">+</button>
                <button class="zoom-btn" onclick="zoomOut()" title="Zoom Out">−</button>
                <button class="zoom-btn" onclick="resetZoom()" title="Reset Zoom">⟲</button>
            </div>
        </div>

        <div class="tooltip" id="tooltip"></div>

        <div class="stats-panel" id="stats-panel">
            <div class="stat-item">
                <div class="stat-number" id="stat-nodes">0</div>
                <div class="stat-label">Total Nodes</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="stat-risks">0</div>
                <div class="stat-label">Risks</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="stat-assets">0</div>
                <div class="stat-label">Assets</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="stat-controls">0</div>
                <div class="stat-label">Controls</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="stat-links">0</div>
                <div class="stat-label">Connections</div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('cdn/updated3.min.js') }}"></script>
    <script>
        let simulation, svg, g, link, node, zoomBehavior;
        let currentTransform = d3.zoomIdentity;
        let physicsEnabled = true;
        let allNodes = [], allLinks = [];
        let highlightTimeout = null;

        document.addEventListener('DOMContentLoaded', function() {
            showLoading();
            const treeData = @json($treeData);
            
            const graphData = convertTreeToGraph(treeData);
            allNodes = graphData.nodes;
            allLinks = graphData.links;

            initializeGraph(graphData);
            updateStats(graphData);
            setupFilters();
            setupSearch();
            hideLoading();
        });

        function showLoading() {
            document.getElementById('loading').classList.add('active');
        }

        function hideLoading() {
            document.getElementById('loading').classList.remove('active');
        }

        function convertTreeToGraph(tree) {
            const nodes = [];
            const links = [];
            let nodeId = 0;

            function traverse(node, parentId = null) {
                const currentId = nodeId++;
                const graphNode = {
                    id: currentId,
                    originalId: node.id,
                    name: node.name,
                    type: node.type,
                    details: node.details,
                    visible: true
                };
                nodes.push(graphNode);

                if (parentId !== null) {
                    links.push({
                        source: parentId,
                        target: currentId
                    });
                }

                if (node.children) {
                    node.children.forEach(child => traverse(child, currentId));
                }
            }

            traverse(tree);
            return { nodes, links };
        }

        function initializeGraph(data) {
            const container = document.getElementById('graph-container');
            const width = container.clientWidth;
            const height = container.clientHeight;

            d3.select('#graph-container svg').remove();

            svg = d3.select('#graph-container')
                .append('svg')
                .attr('width', width)
                .attr('height', height);

            zoomBehavior = d3.zoom()
                .scaleExtent([0.1, 8])
                .on('zoom', (event) => {
                    currentTransform = event.transform;
                    g.attr('transform', currentTransform);
                });

            svg.call(zoomBehavior);

            g = svg.append('g');

            simulation = d3.forceSimulation(data.nodes)
                .force('link', d3.forceLink(data.links).id(d => d.id).distance(120))
                .force('charge', d3.forceManyBody().strength(-500))
                .force('center', d3.forceCenter(width / 2, height / 2))
                .force('collision', d3.forceCollide().radius(35))
                .force('x', d3.forceX(width / 2).strength(0.05))
                .force('y', d3.forceY(height / 2).strength(0.05));

            link = g.append('g')
                .attr('class', 'links')
                .selectAll('line')
                .data(data.links)
                .enter().append('line')
                .attr('class', 'link');

            node = g.append('g')
                .attr('class', 'nodes')
                .selectAll('g')
                .data(data.nodes)
                .enter().append('g')
                .attr('class', 'node')
                .call(d3.drag()
                    .on('start', dragstarted)
                    .on('drag', dragged)
                    .on('end', dragended))
                .on('click', handleNodeClick)
                .on('mouseover', showTooltip)
                .on('mouseout', hideTooltip);

            node.append('circle')
                .attr('r', d => getNodeSize(d))
                .attr('fill', d => getNodeColor(d));

            node.append('text')
                .attr('dy', d => getNodeSize(d) + 18)
                .attr('text-anchor', 'middle')
                .text(d => getNodeLabel(d));

            simulation.on('tick', () => {
                link
                    .attr('x1', d => d.source.x)
                    .attr('y1', d => d.source.y)
                    .attr('x2', d => d.target.x)
                    .attr('y2', d => d.target.y);

                node.attr('transform', d => `translate(${d.x},${d.y})`);
            });
        }

        function getNodeSize(d) {
            if (d.type === 'center') return 24;
            if (d.type === 'risk') return 18;
            if (d.type === 'assets' || d.type === 'controls' || d.type === 'exceptions') return 14;
            return 12;
        }

        function getNodeColor(d) {
            if (d.type === 'center') return '#4facfe';
            if (d.type === 'risk') return d.details?.color_inherent || '#f093fb';
            if (d.type === 'asset') return '#00b894';
            if (d.type === 'control') return '#0984e3';
            if (d.type === 'exception') return '#fdcb6e';
            if (d.type === 'threat') return '#e17055';
            if (d.type === 'controls') return '#f093fb';
            if (d.type === 'exceptions') return '#764ba2';
            if (d.type === 'assets') return '#00cec9';
            return '#95a5a6';
        }

        function getNodeLabel(d) {
            if (d.type === 'risk') return 'R' + (d.originalId || '');
            if (d.type === 'asset') return d.details?.name?.substring(0, 15) || 'Asset';
            if (d.type === 'exception') return d.details?.title?.substring(0, 15) || 'Exception';
            if (d.type === 'control') return d.details?.name?.substring(0, 15) || 'Control';
            if (d.type === 'threat') return d.details?.name?.substring(0, 15) || 'Threat';
            return (d.name || d.originalId || '').substring(0, 15);
        }

        function handleNodeClick(event, d) {
            event.stopPropagation();
            
            if (highlightTimeout) {
                clearTimeout(highlightTimeout);
            }

            const connectedNodes = new Set();
            connectedNodes.add(d.id);
            
            allLinks.forEach(l => {
                if (l.source.id === d.id) connectedNodes.add(l.target.id);
                if (l.target.id === d.id) connectedNodes.add(l.source.id);
            });

            node.classed('dimmed', n => !connectedNodes.has(n.id));
            link.classed('highlighted', l => l.source.id === d.id || l.target.id === d.id)
                .classed('dimmed', l => !(l.source.id === d.id || l.target.id === d.id));

            highlightTimeout = setTimeout(() => {
                node.classed('dimmed', false);
                link.classed('highlighted', false).classed('dimmed', false);
            }, 4000);
        }

        function showTooltip(event, d) {
            const tooltip = d3.select('#tooltip');
            let content = generateTooltipContent(d);
            
            tooltip.html(content).classed('show', true);

            const container = document.getElementById('graph-container');
            const tooltipNode = tooltip.node();
            const containerRect = container.getBoundingClientRect();
            const tooltipRect = tooltipNode.getBoundingClientRect();

            let x = event.clientX - containerRect.left + 20;
            let y = event.clientY - containerRect.top - tooltipRect.height - 20;

            if (y < 0) y = event.clientY - containerRect.top + 30;
            if (x + tooltipRect.width > containerRect.width) x = containerRect.width - tooltipRect.width - 20;
            if (x < 0) x = 10;

            tooltip.style('left', x + 'px').style('top', y + 'px');
        }

        function hideTooltip() {
            d3.select('#tooltip').classed('show', false);
        }

        function generateTooltipContent(d) {
            if (d.type === 'center') {
                return `<div class='tooltip-title'>⚖️ Risk Management Center</div>
                    <div class='tooltip-section'>Central hub for all risk-related entities</div>`;
            } else if (d.type === 'risk') {
                return `<div class='tooltip-title'>⚠️ Risk: ${d.name || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>ID:</span> ${d.originalId || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Status:</span> ${d.details?.status || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Subject:</span> ${d.details?.subject || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Location:</span> ${d.details?.location || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Team:</span> ${d.details?.team || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Inherent Risk:</span> ${d.details?.inherent_risk || 'N/A'} <span class='risk-indicator' style='background:${d.details?.color_inherent || '#ccc'}'></span></div>`;
            } else if (d.type === 'asset') {
                const asset = d.details || {};
                return `<div class='tooltip-title'>🏢 Asset Details</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Name:</span> ${asset.name || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>IP Address:</span> ${asset.ip || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Category:</span> ${asset.category || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Asset Value:</span> ${asset.assetvalue || 'N/A'}</div>`;
            } else if (d.type === 'control') {
                const control = d.details || {};
                return `<div class='tooltip-title'>🛡️ Control Measure</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Name:</span> ${control.name || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Type:</span> ${control.control_type || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Maturity Level:</span> ${control.control_maturity || 'N/A'}</div>`;
            } else if (d.type === 'exception') {
                const exception = d.details || {};
                return `<div class='tooltip-title'>🚩 Risk Exception</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Title:</span> ${exception.title || 'N/A'}</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Creator:</span> ${exception.exception_creator || 'N/A'}</div>`;
            } else if (d.type === 'threat') {
                const threat = d.details || {};
                return `<div class='tooltip-title'>⚡ Threat Vector</div>
                    <div class='tooltip-section'><span class='tooltip-label'>Name:</span> ${threat.name || 'N/A'}</div>`;
            }
            return `<div class='tooltip-title'>${d.name || d.type || 'Node'}</div>`;
        }

        function dragstarted(event, d) {
            if (!event.active && physicsEnabled) simulation.alphaTarget(0.3).restart();
            d.fx = d.x;
            d.fy = d.y;
        }

        function dragged(event, d) {
            d.fx = event.x;
            d.fy = event.y;
        }

        function dragended(event, d) {
            if (!event.active && physicsEnabled) simulation.alphaTarget(0);
            d.fx = null;
            d.fy = null;
        }

        function updateStats(data) {
            const stats = {
                total: data.nodes.length,
                risks: data.nodes.filter(n => n.type === 'risk').length,
                assets: data.nodes.filter(n => n.type === 'asset').length,
                controls: data.nodes.filter(n => n.type === 'control').length,
                links: data.links.length
            };

            animateValue('stat-nodes', 0, stats.total, 1000);
            animateValue('stat-risks', 0, stats.risks, 1000);
            animateValue('stat-assets', 0, stats.assets, 1000);
            animateValue('stat-controls', 0, stats.controls, 1000);
            animateValue('stat-links', 0, stats.links, 1000);
        }

        function animateValue(id, start, end, duration) {
            const element = document.getElementById(id);
            const range = end - start;
            const increment = end > start ? 1 : -1;
            const stepTime = Math.abs(Math.floor(duration / range));
            let current = start;

            const timer = setInterval(() => {
                current += increment;
                element.textContent = current;
                if (current === end) {
                    clearInterval(timer);
                }
            }, stepTime);
        }

        function setupFilters() {
            document.querySelectorAll('.filter-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', applyFilters);
            });
        }

        function applyFilters() {
            const activeTypes = Array.from(document.querySelectorAll('.filter-checkbox:checked'))
                .map(cb => cb.dataset.type);
            
            node.style('display', d => {
                if (d.type === 'center') return 'block';
                return activeTypes.includes(d.type) ? 'block' : 'none';
            });

            link.style('display', l => {
                const sourceVisible = l.source.type === 'center' || activeTypes.includes(l.source.type);
                const targetVisible = l.target.type === 'center' || activeTypes.includes(l.target.type);
                return sourceVisible && targetVisible ? 'block' : 'none';
            });

            simulation.alpha(0.3).restart();
        }

        function setupSearch() {
            const searchInput = document.getElementById('search-input');
            let searchTimeout;

            searchInput.addEventListener('input', (e) => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    const query = e.target.value.toLowerCase().trim();
                    
                    if (query === '') {
                        node.classed('dimmed', false);
                        link.classed('dimmed', false);
                        return;
                    }

                    const matchingNodes = new Set();
                    
                    node.each(d => {
                        const label = getNodeLabel(d).toLowerCase();
                        const name = (d.name || '').toLowerCase();
                        const details = JSON.stringify(d.details || {}).toLowerCase();
                        
                        if (label.includes(query) || name.includes(query) || details.includes(query)) {
                            matchingNodes.add(d.id);
                        }
                    });

                    node.classed('dimmed', d => !matchingNodes.has(d.id));
                    link.classed('dimmed', l => !matchingNodes.has(l.source.id) && !matchingNodes.has(l.target.id));
                }, 300);
            });
        }

        function resetSimulation() {
            showLoading();
            simulation.alpha(1).restart();
            setTimeout(hideLoading, 500);
        }

        function togglePhysics() {
            physicsEnabled = !physicsEnabled;
            const indicator = document.getElementById('mode-indicator');
            const text = document.getElementById('physics-text');
            
            if (physicsEnabled) {
                simulation.alpha(0.3).restart();
                indicator.textContent = '⚡ Physics: Active';
                text.textContent = 'Disable';
            } else {
                simulation.stop();
                indicator.textContent = '🔒 Physics: Locked';
                text.textContent = 'Enable';
            }
        }

        function fitToScreen() {
            showLoading();
            
            setTimeout(() => {
                const bounds = g.node().getBBox();
                const container = document.getElementById('graph-container');
                const width = container.clientWidth;
                const height = container.clientHeight;
                
                const fullWidth = bounds.width;
                const fullHeight = bounds.height;
                const midX = bounds.x + fullWidth / 2;
                const midY = bounds.y + fullHeight / 2;
                
                if (fullWidth === 0 || fullHeight === 0) {
                    hideLoading();
                    return;
                }
                
                const scale = 0.85 / Math.max(fullWidth / width, fullHeight / height);
                const translate = [width / 2 - scale * midX, height / 2 - scale * midY];

                svg.transition()
                    .duration(750)
                    .call(zoomBehavior.transform, d3.zoomIdentity.translate(translate[0], translate[1]).scale(scale))
                    .on('end', hideLoading);
            }, 100);
        }

        function centerGraph() {
            showLoading();
            const container = document.getElementById('graph-container');
            const width = container.clientWidth;
            const height = container.clientHeight;

            svg.transition()
                .duration(750)
                .call(zoomBehavior.transform, d3.zoomIdentity.translate(width / 2, height / 2).scale(1))
                .on('end', hideLoading);
        }

        function zoomIn() {
            svg.transition()
                .duration(300)
                .call(zoomBehavior.scaleBy, 1.4);
        }

        function zoomOut() {
            svg.transition()
                .duration(300)
                .call(zoomBehavior.scaleBy, 0.7);
        }

        function resetZoom() {
            svg.transition()
                .duration(750)
                .call(zoomBehavior.transform, d3.zoomIdentity);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', (e) => {
            if (e.key === 'r' || e.key === 'R') {
                resetSimulation();
            } else if (e.key === 'f' || e.key === 'F') {
                fitToScreen();
            } else if (e.key === 'c' || e.key === 'C') {
                centerGraph();
            } else if (e.key === '+' || e.key === '=') {
                zoomIn();
            } else if (e.key === '-' || e.key === '_') {
                zoomOut();
            } else if (e.key === '0') {
                resetZoom();
            } else if (e.key === 'p' || e.key === 'P') {
                togglePhysics();
            }
        });

        // Click on background to clear highlights
        svg.on('click', () => {
            if (highlightTimeout) {
                clearTimeout(highlightTimeout);
            }
            node.classed('dimmed', false);
            link.classed('highlighted', false).classed('dimmed', false);
        });

        // Handle window resize
        window.addEventListener('resize', () => {
            const container = document.getElementById('graph-container');
            const width = container.clientWidth;
            const height = container.clientHeight;
            
            svg.attr('width', width).attr('height', height);
            simulation.force('center', d3.forceCenter(width / 2, height / 2));
            simulation.alpha(0.3).restart();
        });
    </script>
@endsection