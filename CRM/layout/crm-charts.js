/*
 * Shared Chart.js (v4) look for every CRM page, loaded by layout/top.php.
 *
 * Pages keep creating charts as before; this plugin then
 *  - maps each dataset colour to the nearest hue of one modern palette (so "green = done" still holds),
 *  - rounds bars, smooths lines with a soft gradient fill and thins doughnuts,
 *  - colours axes, grid, legend and tooltips from the light/dark theme tokens in layout.css.
 * window.crmCharts.refresh() re-applies the theme after the dark/light toggle.
 */
(function () {
  if (!window.Chart) return;
  var Chart = window.Chart;

  var PALETTE = ['#6366f1', '#3b82f6', '#0ea5e9', '#14b8a6', '#10b981', '#84cc16', '#f59e0b', '#f97316', '#f43f5e', '#ec4899', '#8b5cf6'];

  function token(name, fallback) {
    var v = getComputedStyle(document.documentElement).getPropertyValue(name).trim();
    return v || fallback;
  }

  function parse(c) {
    if (typeof c !== 'string') return null;
    c = c.trim();
    var m = /^#([0-9a-f]{3}|[0-9a-f]{6})$/i.exec(c);
    if (m) {
      var h = m[1].length === 3 ? m[1].replace(/./g, '$&$&') : m[1];
      return { r: parseInt(h.slice(0, 2), 16), g: parseInt(h.slice(2, 4), 16), b: parseInt(h.slice(4, 6), 16), a: 1 };
    }
    m = /^rgba?\(\s*([\d.]+)\s*,\s*([\d.]+)\s*,\s*([\d.]+)\s*(?:,\s*([\d.]+)\s*)?\)$/i.exec(c);
    return m ? { r: +m[1], g: +m[2], b: +m[3], a: m[4] === undefined ? 1 : +m[4] } : null;
  }

  function hsl(c) {
    var r = c.r / 255, g = c.g / 255, b = c.b / 255;
    var max = Math.max(r, g, b), min = Math.min(r, g, b), l = (max + min) / 2, d = max - min, h = 0, s = 0;
    if (d) {
      s = d / (1 - Math.abs(2 * l - 1));
      h = max === r ? ((g - b) / d) % 6 : max === g ? (b - r) / d + 2 : (r - g) / d + 4;
      h = (h * 60 + 360) % 360;
    }
    return { h: h, s: s, l: l };
  }

  var hues = PALETTE.map(function (p) { return hsl(parse(p)).h; });

  function rgba(hex, a) {
    var c = parse(hex);
    return 'rgba(' + c.r + ',' + c.g + ',' + c.b + ',' + a + ')';
  }

  // Nearest palette colour by hue, keeping the original transparency; greys/whites stay as they are.
  function remap(color) {
    var c = parse(color);
    if (!c) return color;
    var x = hsl(c);
    if (x.s < 0.18 || x.l > 0.94 || x.l < 0.06) return color;
    var best = 0, bestD = 999;
    hues.forEach(function (h, i) {
      var d = Math.abs(h - x.h);
      d = Math.min(d, 360 - d);
      if (d < bestD) { bestD = d; best = i; }
    });
    return c.a >= 1 ? PALETTE[best] : rgba(PALETTE[best], c.a);
  }

  function remapAll(v) { return Array.isArray(v) ? v.map(remap) : remap(v); }

  // Pages build their own gradients from legacy colours; route every colour stop through the palette too.
  if (window.CanvasGradient && !CanvasGradient.prototype.addColorStop._crm) {
    var addStop = CanvasGradient.prototype.addColorStop;
    CanvasGradient.prototype.addColorStop = function (offset, color) { return addStop.call(this, offset, remap(color)); };
    CanvasGradient.prototype.addColorStop._crm = true;
  }

  function theme() {
    return {
      text: token('--crm-chart-text', '#475569'),
      muted: token('--crm-chart-muted', '#94a3b8'),
      grid: token('--crm-chart-grid', 'rgba(148,163,184,.18)'),
      surface: token('--crm-surface', '#ffffff'),
      tipBg: token('--crm-chart-tooltip', '#0f172a'),
      tipText: token('--crm-chart-tooltip-text', '#f8fafc'),
      font: token('--crm-font', 'Inter, system-ui, sans-serif').replace(/^"|"$/g, ''),
    };
  }

  function set(obj, key) { obj[key] = obj[key] && typeof obj[key] === 'object' ? obj[key] : {}; return obj[key]; }

  function styleDatasets(chart) {
    var type = chart.config.type, t = theme();
    (chart.data.datasets || []).forEach(function (ds) {
      var dsType = ds.type || type;
      if (typeof ds.backgroundColor !== 'function' && !(ds.backgroundColor instanceof CanvasGradient)) ds.backgroundColor = remapAll(ds.backgroundColor);
      if (typeof ds.borderColor !== 'function') ds.borderColor = remapAll(ds.borderColor);
      if (ds.hoverBackgroundColor) ds.hoverBackgroundColor = remapAll(ds.hoverBackgroundColor);
      if (ds.pointBackgroundColor) ds.pointBackgroundColor = remapAll(ds.pointBackgroundColor);

      if (dsType === 'doughnut' || dsType === 'pie' || dsType === 'polarArea') {
        if (!ds.backgroundColor || (Array.isArray(ds.backgroundColor) && !ds.backgroundColor.length)) ds.backgroundColor = PALETTE;
        ds.borderColor = t.surface;
        // A ring with one slice would otherwise show a seam where it starts.
        ds.borderWidth = (ds.data || []).filter(function (v) { return Number(v) > 0; }).length > 1 ? 3 : 0;
        ds.hoverOffset = 6;
        ds.borderRadius = dsType === 'doughnut' && ds.borderWidth ? 6 : 0;
        delete ds.hoverBackgroundColor;
      } else if (dsType === 'bar') {
        if (ds.borderRadius === undefined) ds.borderRadius = 8;
        ds.borderSkipped = false;
        ds.borderWidth = 0;
        if (ds.maxBarThickness === undefined) ds.maxBarThickness = 38;
      } else if (dsType === 'line') {
        var line = typeof ds.borderColor === 'string' ? ds.borderColor : (typeof ds.backgroundColor === 'string' ? ds.backgroundColor : PALETTE[0]);
        var solid = parse(line) ? remap(line.replace(/rgba\(([^)]+),\s*[\d.]+\)/, 'rgb($1)')) : PALETTE[0];
        ds.borderColor = solid;
        ds.borderWidth = 2.5;
        if (ds.tension === undefined) ds.tension = 0.4;
        ds.pointRadius = ds.pointRadius === undefined ? 3 : ds.pointRadius;
        ds.pointHoverRadius = 6;
        ds.pointBackgroundColor = t.surface;
        ds.pointBorderColor = solid;
        ds.pointBorderWidth = 2;
        if (ds.fill && typeof ds.backgroundColor !== 'function' && parse(solid)) {
          var hex = solid.charAt(0) === '#' ? solid : PALETTE[0];
          ds.backgroundColor = function (ctx) {
            var area = ctx.chart.chartArea;
            if (!area) return rgba(hex, 0.15);
            var g = ctx.chart.ctx.createLinearGradient(0, area.top, 0, area.bottom);
            g.addColorStop(0, rgba(hex, 0.32));
            g.addColorStop(1, rgba(hex, 0));
            return g;
          };
        }
      }
    });
  }

  function styleOptions(chart) {
    var t = theme(), type = chart.config.type, opts = chart.config.options;
    var plugins = set(opts, 'plugins');

    var legend = set(plugins, 'legend'), labels = set(legend, 'labels');
    labels.color = t.text;
    labels.usePointStyle = true;
    labels.pointStyle = 'circle';
    labels.boxWidth = 8;
    labels.boxHeight = 8;
    labels.padding = 16;
    set(labels, 'font').family = t.font;
    labels.font.weight = 500;
    // Hand-written legend items carry no text colour of their own; give them the theme's.
    if (labels.generateLabels && !labels.generateLabels._crm) {
      var gen = labels.generateLabels;
      labels.generateLabels = function (c) {
        return gen.call(this, c).map(function (item) {
          item.fontColor = theme().text;
          item.strokeStyle = 'transparent';
          return item;
        });
      };
      labels.generateLabels._crm = true;
    }

    var tip = set(plugins, 'tooltip');
    tip.backgroundColor = t.tipBg;
    tip.titleColor = t.tipText;
    tip.bodyColor = t.tipText;
    tip.borderColor = 'rgba(148,163,184,.25)';
    tip.borderWidth = 1;
    tip.padding = 12;
    tip.cornerRadius = 10;
    tip.boxPadding = 4;
    tip.usePointStyle = true;
    set(tip, 'titleFont').family = t.font;
    set(tip, 'bodyFont').family = t.font;

    var title = plugins.title;
    if (title) { title.color = t.text; set(title, 'font').family = t.font; }

    if (type === 'doughnut' || type === 'pie') {
      if (type === 'doughnut' && (opts.cutout === undefined || opts.cutout === '50%')) opts.cutout = '68%';
      return;
    }
    var scales = set(opts, 'scales');
    var ids = Object.keys(scales);
    if (!ids.length) ids = type === 'radar' || type === 'polarArea' ? ['r'] : ['x', 'y'];
    ids.forEach(function (id) {
      var s = set(scales, id);
      var ticks = set(s, 'ticks'), grid = set(s, 'grid'), border = set(s, 'border');
      ticks.color = t.muted;
      set(ticks, 'font').family = t.font;
      grid.color = t.grid;
      border.display = false;
      if (id === 'r') {
        set(s, 'angleLines').color = t.grid;
        set(s, 'pointLabels').color = t.text;
        ticks.backdropColor = 'transparent';
      } else if (id === 'x' || s.axis === 'x') {
        grid.display = s.indexAxis === 'y' || opts.indexAxis === 'y';
      }
      if (s.title) { s.title.color = t.muted; set(s.title, 'font').family = t.font; }
    });
  }

  function isEmpty(chart) {
    return !(chart.data.datasets || []).some(function (ds) {
      return (ds.data || []).some(function (v) { return Number(v && typeof v === 'object' ? v.y : v) > 0; });
    });
  }

  Chart.register({
    id: 'crmTheme',
    beforeInit: function (chart) { styleOptions(chart); },
    beforeUpdate: function (chart) { styleDatasets(chart); },
    // "No data yet" instead of a blank card.
    afterDraw: function (chart) {
      if (!isEmpty(chart)) return;
      var ctx = chart.ctx, area = chart.chartArea, t = theme();
      if (!area) return;
      ctx.save();
      ctx.textAlign = 'center';
      ctx.textBaseline = 'middle';
      ctx.fillStyle = t.muted;
      ctx.font = '500 13px ' + t.font;
      ctx.fillText('No data yet', (area.left + area.right) / 2, (area.top + area.bottom) / 2);
      ctx.restore();
    },
  });

  function applyDefaults() {
    var t = theme();
    Chart.defaults.font.family = t.font;
    Chart.defaults.color = t.muted;
    Chart.defaults.borderColor = t.grid;
    Chart.defaults.animation.duration = 700;
  }
  applyDefaults();

  // Drawing a chart on a canvas that already has one replaces it, so dashboards can redraw with fresh data.
  var BaseChart = Chart;
  function CrmChart(item, config) {
    var previous = BaseChart.getChart(item);
    if (previous) previous.destroy();
    return new BaseChart(item, config);
  }
  Object.setPrototypeOf(CrmChart, BaseChart);
  CrmChart.prototype = BaseChart.prototype;
  window.Chart = CrmChart;

  window.crmCharts = {
    palette: PALETTE,
    refresh: function () {
      applyDefaults();
      Object.values(BaseChart.instances || {}).forEach(function (chart) {
        styleOptions(chart);
        chart.update('none');
      });
    },
  };
})();
