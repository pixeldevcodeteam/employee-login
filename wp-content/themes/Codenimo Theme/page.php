<?php get_header(); ?>

<section class="dashboard">
    <div class="titleContent">
        <h1>Dashboard</h1>
    </div>
    <div class="container">
        <div class="content">
            <div class="leftContent">
                <div class="profileContainer">
                    <?php do_shortcode('[user_info]')?>
                </div>
                <div class="calendarContainer">
                <div class="calendar-container">
                    <header class="calendar-header">
                        <p class="calendar-current-date"></p>
                        <div class="calendar-navigation">
                        <span id="calendar-prev" class="material-symbols-rounded">
                                <i class="fa-solid fa-angle-left"></i>
                        </span>
                        <span id="calendar-next" class="material-symbols-rounded">
                                <i class="fa-solid fa-angle-right"></i>
                        </span>
                        </div>
                    </header>
                    <div class="calendar-body">
                        <ul class="calendar-weekdays">
                        <li>Sun</li>
                        <li>Mon</li>
                        <li>Tue</li>
                        <li>Wed</li>
                        <li>Thu</li>
                        <li>Fri</li>
                        <li>Sat</li>
                        </ul>
                        <ul class="calendar-dates"></ul>
                    </div>
                    </div>
                </div>
                <div class="attendanceContainer">
                    <button id="create-attendance" class="create-attendance-btn">Login</button>
                    <div id="attendance-message"></div>
                </div>
            </div>
            <div class="rightContent">
                <div class="headingRightContent">
                    <div class="hourContent">
                        <div class="totalhrsContent">
                            <h2>Total hours</h2>
                            <div class="hrsContent">
                                <p>0</p>
                            </div>
                            
                        </div>
                        <div class="totalweekhrsContent">
                            <h2>Total Week hours</h2>
                            <div class="hrsContent">
                                <p>0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</section>


<?php get_footer(); ?>
