<!doctype html>

<html>

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Zebra_Datepicker is a super-lightweight, highly configurable, cross-browser date picker jQuery plugin">
        <title>Zebra_Datepicker - a super-lightweight, highly configurable, cross-browser date picker jQuery plugin</title>

        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/styles/shCoreDefault.min.css" />-->

        <link rel="stylesheet" href="../dist/css/default/zebra_datepicker.min.css" type="text/css">
        <link rel="stylesheet" href="examples.css" type="text/css">

        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shCore.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushJScript.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushXml.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/SyntaxHighlighter/3.0.83/scripts/shBrushCss.min.js"></script>-->

        <script type="text/javascript">
            SyntaxHighlighter.defaults['toolbar'] = false;
            SyntaxHighlighter.all();
        </script>

    </head>

    <body>

        <a href="https://github.com/stefangabos/Zebra_Datepicker"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/652c5b9acfaddf3a9c326fa6bde407b87f7be0f4/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f6f72616e67655f6666373630302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_orange_ff7600.png"></a>

        <div class="container">

            <div class="row">

                <div class="col-xs-12">

                    <div class="page-header">
                        <h1>Zebra_Datepicker Demos</h1>
                    </div>

                    <blockquote>See the examples using the <a href="metallic.html">metallic</a> theme or the <a href="bootstrap.html">bootstrap</a> theme.</blockquote>

                    <p>Zebra_Datepicker is a small, compact and highly configurable datepicker jQuery plugin, meant to
                    enrich forms by adding the datepicker functionality to them. This jQuery plugin will automatically add
                    a calendar icon to the indicated input fields which, when clicked, will open the attached datepicker.
                    Users can easily jump between months and years due to the datepicker’s intuitive interface. The selected
                    date will be entered in the input field using the date format of choice, configurable in the datepicker’s options.</p>

                    <hr>

                    <div class="row">
                        <div class="col-sm-6">
                            1. <a href="#default-initialization">Default initialization</a><br>
                            2. <a href="#future-tomorrow">Allow future dates only starting one day in the future</a><br>
                            3. <a href="#dynamic-interval">Allow dates from a dynamic interval</a><br>
                            4. <a href="#dates-interval">Allow dates from an interval between 2 dates</a><br>
                            5. <a href="#after-date">Allow only dates that come after a certain date</a><br>
                            6. <a href="#disable-dates">Disable dates</a><br>
                            7. <a href="#date-range">Date ranges (sort of)</a><br>
                            8. <a href="#date-formats">Date formats</a><br>
                        </div>
                        <div class="col-sm-6">
                            9. <a href="#time">Enabling the time picker</a><br>
                            10. <a href="#partial-formats">Partial date formats</a><br>
                            11. <a href="#week-number">Showing week numbers</a><br>
                            12. <a href="#starting-view">Changing the starting view</a><br>
                            13. <a href="#custom-classes">Custom classes</a><br>
                            14. <a href="#on-change">Handling the "onChange" event</a><br>
                            15. <a href="#always-visible">Always-visible date pickers</a><br>
                            16. <a href="#data-attributes">Data attributes</a><br>
                        </div>
                    </div>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="default-initialization"></a><strong>1.</strong> Default initialization</h3>

                    <p>
                        All dates are selectable, no restrictions.<br>
                        There are <strong>a lot</strong> of things that can be <a href="https://github.com/stefangabos/Zebra_Datepicker#properties" target="_blank">configured</a>!
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker();
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="future-tomorrow"></a><strong>2.</strong> Allow future dates only starting one day in the future</h3>

                    <p>
                        All past dates, including today, are disabled.<br>
                        Read more about using the <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-direction" target="_blank">direction</a> property.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        direction: 1
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-future-tomorrow" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="dynamic-interval"></a><strong>3. </strong> Allow dates from a dynamic interval</h3>

                    <p>
                        The selectable dates are in the interval starting tomorrow and ending 10 days after that.<br>
                        Read more about using the <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-direction" target="_blank">direction</a> property.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        direction: [1, 10]
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-dynamic-interval" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="dates-interval"></a><strong>4.</strong> Allow dates from an interval between 2 dates</h3>

                    <p>
                        Dates in the <code>direction</code> property have to be written in the date picker's <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-format">date format</a>.<br>
                        Read more about using the <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-direction" target="_blank">direction</a> property.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        direction: ['2012-08-01', '2012-08-12']
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-dates-interval" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="after-date"></a><strong>5.</strong> Allow only dates that come after a certain date</h3>

                    <p>
                        Dates in the <code>direction</code> property have to be written in the date picker's <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-format">date format</a>.<br>
                        Read more about using the <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-direction" target="_blank">direction</a> property.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        direction: ['2012-08-01', false]
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-after-date" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="disable-dates"></a><strong>6.</strong> Disable dates</h3>

                    <p>
                        Allow future dates only including the current day.<br>
                        All past dates are disabled.<br>
                        Saturday and Sundays are disabled.<br>
                        Read more about using the <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-direction" target="_blank">direction</a> property and about <a href="https://github.com/stefangabos/Zebra_Datepicker#user-content-disabled_dates" target="_blank">disabling dates</a>.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        direction: true,
                        disabled_dates: ['* * * 0,6']   // all days, all monts, all years as long
                                                        // as the weekday is 0 or 6 (Sunday or Saturday)
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-disabled-dates" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="date-range"></a><strong>7.</strong> Date ranges (sort of)</h3>

                    <p>The second date picker's starting date is the value of the first date picker + 1</p>

                    <pre class="brush:js">
                    $('#datepicker-range-start').Zebra_DatePicker({
                        direction: true,
                        pair: $('#datepicker-range-end')
                    });

                    $('#datepicker-range-end').Zebra_DatePicker({
                        direction: 1
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-range-start" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                            <div class="col-sm-2">
                                <input id="datepicker-range-end" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="date-formats"></a><strong>8.</strong> Date formats</h3>

                    <p>
                        Accepts the following characters for date formatting: <code>d</code>, <code>D</code>, <code>j</code>,
                        <code>l</code>, <code>N</code>, <code>w</code>, <code>S</code>, <code>F</code>, <code>m</code>,
                        <code>M</code>, <code>n</code>, <code>Y</code>, <code>y</code>, <code>h</code>, <code>H</code>,
                        <code>g</code>, <code>G</code>, <code>i</code>, <code>s</code>, <code>a</code>, <code>A</code>,
                        borrowing the syntax from PHP's <a href="http://php.net/manual/en/function.date.php">date</a>
                        function.<br>

                        If <code>format</code> property contains time-related characters (<code>g</code>, <code>G</code>,
                        <code>h</code>, <code>H</code>, <code>i</code>, <code>s</code>, <code>a</code>, <code>A</code>),
                        the time picker will be automatically enabled.<br>

                        Note that when setting a date format without days (<code>d</code>, <code>j</code>), the users will
                        be able to select only years and months, and when setting a format without months and days
                        (<code>F</code>, <code>m</code>, <code>M</code>, <code>n</code>, <code>t</code>, <code>d</code>,
                        <code>j</code>), the users will be able to select only years. Similarly, setting a format that
                        contains only time-related characters, will result in users being able to only select time.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        format: 'M d, Y'
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-formats" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="time"></a><strong>9.</strong> Enabling the time picker</h3>

                    <p>
                        If <code>format</code> property contains time-related characters (<code>g</code>, <code>G</code>,
                        <code>h</code>, <code>H</code>, <code>i</code>, <code>s</code>, <code>a</code>, <code>A</code>),
                        the time picker will be automatically enabled.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        format: 'Y-m-d H:i'
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-time" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="partial-formats"></a><strong>10.</strong> Partial date formats</h3>

                    <p>
                        The date picker will not show views that are not present in format.<br>

                        In the example below, the date picker will never get to the <code>day</code> view as there is no
                        <code>day</code>-related character in the date's format.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        format: 'm Y',
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-partial-date-formats" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="week-number"></a><strong>11.</strong> Showing week numbers</h3>

                    <p>
                        Show the <a href="https://en.wikipedia.org/wiki/ISO_8601" target="_blank">ISO 8601</a> week number.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        show_week_number: 'Wk'
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-week-number" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="starting-view"></a><strong>12.</strong> Changing the starting view</h3>

                    <p>
                        Start with the <code>years</code> view, recommended for when users need to select their birth
                        date.<br>

                        You can always switch between views by clicking on caption in the date picker's header, between
                        the <code>previous</code> and <code>next</code> buttons!<br>

                        Note that the date picker is always cycling <code>days -> months -> years</code> when clicking
                        on the date picker's header, and <code>years -> months -> days</code> when selecting dates (skipping
                        the views that are missing because of the date's format)<br>

                        Also note that the value of the <em>view</em> property may be overridden if the date's format requires so! (i.e. <code>days</code> for the <em>view</em> property makes no sense if the date format doesn't allow the selection of days)

                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        view: 'years'
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-starting-view" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="custom-classes"></a><strong>13.</strong> Custom classes</h3>

                    <p>
                        Disable weekends and apply a custom class to Saturdays and Sundays.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        disabled_dates: ['* * * 0,6'],
                        custom_classes: {
                            'myclass':  ['* * * 0,6']
                        }
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-custom-classes" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="on-change"></a><strong>14.</strong> Handling the "onChange" event</h3>

                    <p>
                        If a callback function is attached to the <code>onChange</code> event, it will be called whenever
                        the user changes the view (days/months/years), as well as when the user navigates by clicking on
                        the next/previous icons in any of the views.
                    </p>

                    <p>The callback function takes two arguments:</p>

                    <ul>
                        <li>
                            the view (<code>days</code>, <code>months</code> or <code>years</code>)
                        </li>
                        <li>
                            the <em>active</em> elements (not disabled) in that view, as jQuery elements, allowing for
                            easy customization and interaction with particular cells in the date picker's view
                        </li>
                    </ul>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({

                        // execute a function whenever the user changes the view (days/months/years),
                        // as well as when the user navigates by clicking on the "next"/"previous"
                        // icons in any of the views
                        onChange: function(view, elements) {

                            // on the "days" view...
                            if (view == 'days') {

                                // iterate through the active elements in the view
                                elements.each(function() {

                                    // to simplify searching for particular dates, each element gets a
                                    // "date" data attribute which is the form of:
                                    // - YYYY-MM-DD for elements in the "days" view
                                    // - YYYY-MM for elements in the "months" view
                                    // - YYYY for elements in the "years" view

                                    // so, because we're on a "days" view,
                                    // let's find the 24th day using a regular expression
                                    // (notice that this will apply to every 24th day
                                    // of every month of every year)
                                    if ($(this).data('date').match(/\-24$/))

                                        // and highlight it!
                                        $(this).css({
                                            background: '#C40000',
                                            color:      '#FFF'
                                        });

                                });

                            }

                        }
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-on-change" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="always-visible"></a><strong>15.</strong> Always-visible date pickers</h3>

                    <p>
                        Set the <code>always_visible</code> property's value to a jQuery element which will act as a
                        container for the date picker.<br>Notice that in this case the element the date picker is attached
                        to has no icon.
                    </p>

                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker({
                        always_visible: $('#container')
                    });
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-always-visible" type="text" class="form-control" data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                    <div id="container" style="margin: 10px 0 0 0; height: 255px; position: relative"></div>

                    <a href="#top" class="pull-right clearfix top small">To the top</a>

                    <hr>

                    <!-- =========================================================================================== -->

                    <h3><a name="data-attributes"></a><strong>16.</strong> Data attributes</h3>

                    <p>
                        All the properties of the date picker can also be set via <code>data-attributes</code>.<br>

                        All you have to do is take any property described in the <code>Configuration</code> section and
                        prefix it with <code>data-zdp_</code>.<br>

                        Remember that if the value of the property is an array, you will have to use <em>double
                        quotes</em> inside the square brackets and <em>single quotes</em> around the attribute, like in
                        the example below:
                    </p>

                    <pre class="brush:xml">
                    &lt;input type="text" id="datepicker" data-zdp_direction="1" data-zdp_disabled_dates='["* * * 0,6"]'>
                    </pre>
                    <pre class="brush:js">
                    $('#datepicker').Zebra_DatePicker();
                    </pre>

                    <div class="well">
                        <div class="row">
                            <div class="col-sm-2">
                                <input id="datepicker-data-attributes" type="text" class="form-control" data-zdp_direction="1" data-zdp_disabled_dates='["* * * 0,6"]' data-zdp_readonly_element="false">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="../dist/zebra_datepicker.min.js"></script>
        <script type="text/javascript" src="examples.js"></script>

    </body>

</html>
