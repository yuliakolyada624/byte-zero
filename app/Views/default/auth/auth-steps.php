<?php
if(!isset($step))
    $step = 0;
//d($step);
?>
<div class="component__psteps">
    <div class="component__psteps-wrap">
        <div class="component__psteps-row">
            <div class="component__psteps-step <?= ($step >= 2 ? 'done' : '') ?>">
                <div class="component__psteps-step-icon">
                    <svg class="svg-done" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#148BDF" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg class="svg-wait" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#D4DCE4" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="component__psteps-step-label">
                    Email Confirmation
                </div>
            </div>
            <?php 
            if(getenv('enable2FA')==='true'):
            ?>
            <div class="component__psteps-step <?= ($step >= 3 ? 'done' : '') ?>">
                <div class="component__psteps-step-icon">
                    <svg class="svg-done" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#148BDF" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg class="svg-wait" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#D4DCE4" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="component__psteps-step-label">
                    2FA
                </div>
            </div>
            <?php endif; ?>
            <div class="component__psteps-step <?= ($step >= 4 ? 'done' : '') ?>">
                <div class="component__psteps-step-icon">
                    <svg class="svg-done" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#148BDF" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg class="svg-wait" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#D4DCE4" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="component__psteps-step-label">
                    Password
                </div>
            </div>
            <div class="component__psteps-step ">
                <div class="component__psteps-step-icon">
                    <svg class="svg-done" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#148BDF" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <svg class="svg-wait" width="11" height="9" viewBox="0 0 11 9" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.61667 1.44531L3.52083 7.54115L0.75 4.77031" stroke="#D4DCE4" stroke-width="1.30625"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </div>
                <div class="component__psteps-step-label">
                    Account Details
                </div>
            </div>
        </div>
    </div>
</div>