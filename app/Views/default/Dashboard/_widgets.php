<section id="overviewWidgets" data-url="/dashboard/widgets" class="overview-section__widgets">
    <div class="overview-widgets__line-wrap">
        <div class="overview-widgets__line">
            <div class="overview-widgets__widget owidget--peport">
                <div class="overview-widgets__widget-value"><?= $widgets_data['reports_requested'] ?></div>
                <div class="overview-widgets__widget-title">Reports Requested</div>
            </div>
            <div class="overview-widgets__widget-separator"></div>
            <div class="overview-widgets__widget owidget--exhibits">
                <div class="overview-widgets__widget-value"><?= $widgets_data['exhibits_uploaded'] ?></div>
                <div class="overview-widgets__widget-title">Exhibits Uploaded</div>
            </div>
            <div class="overview-widgets__widget-separator"></div>
            <div class="overview-widgets__widget owidget--pages">
                <div class="overview-widgets__widget-value"><?= number_format($widgets_data['pages_uploaded']) ?></div>
                <div class="overview-widgets__widget-title">Pages Uploaded</div>
            </div>
            <div class="overview-widgets__widget-separator"></div>
            <div class="overview-widgets__widget owidget--peport-generated">
                <div class="overview-widgets__widget-value important"><?= $widgets_data['reports_generated'] ?></div>
                <div class="overview-widgets__widget-title">Reports Generated</div>
            </div>
            <div class="overview-widgets__widget-separator"></div>
            <div class="overview-widgets__widget owidget--avg-rgt">
                <div class="overview-widgets__widget-value"><?= $widgets_data['avg_report_generation_time']['hours'] ?> <span>Hours</span> <?= $widgets_data['avg_report_generation_time']['minutes'] ?> <span>Minutes</span></div>
                <div class="overview-widgets__widget-title">Avg. Report Generation Time</div>
            </div>
        </div>
    </div>
</section>