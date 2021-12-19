@extends('components.layouts.public.layout')

@section('title', 'Homepage')

@section('content')
    <div id="navigation">
        <div class="ui inverted dimmer">
            <div class="ui text loader">Loading</div>
        </div>

        <div class="ui top attached tabular menu">
            <a class="item active" data-tab="squares">Squares</a>
            <a class="item" data-tab="triplets">Triplets</a>
        </div>

        {{-- SQUARE --}}
        <div class="ui bottom attached tab segment active" data-tab="squares">
            <form id="square" name="square" class="ui form">
                <div class="field">
                    <label for="square-n">Number (n)</label>
                    <input id="square-n" name="n" type="number" placeholder="Please provide a number">
                </div>
                <button type="submit" class="ui submit button blue">Submit</button>
            </form>
        </div>

        {{-- TRIPLET --}}
        <div class="ui bottom attached tab segment" data-tab="triplets">
            <form id="triplet" name="triplet" class="ui form">
                <div class="field">
                    <label for="triplet-a">Number (a)</label>
                    <input id="triplet-a" name="a" type="number" placeholder="Please provide a number">
                </div>

                <div class="field">
                    <label for="triplet-b">Number (b)</label>
                    <input id="triplet-b" name="b" type="number" placeholder="Please provide a number">
                </div>

                <div class="field">
                    <label for="triplet-c">Number (c)</label>
                    <input id="triplet-c" name="c" type="number" placeholder="Please provide a number">
                </div>

                <button type="submit" class="ui submit button blue">Submit</button>
            </form>
        </div>
    </div>

    <div id="errors" class="ui error message" style="display: none;">
        <div class="header">API Error</div>
        <p>You can only sign up for an account once with a given e-mail address.</p>
        <p>You can only sign up for an account once with a given e-mail address.</p>
    </div>

    <table id="api-response" class="ui celled striped table" style="display: none;">
        <thead>
            <tr>
                <th colspan="10">
                    API Response
                </th>
            </tr>
        </thead>

        <tbody>
        <tr>
            <td class="collapsing">
                <i class="key icon"></i> node_modules
            </td>
            <td>Initial commit</td>
            <td class="right aligned collapsing">10 hours ago</td>
        </tr>
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        const API_SQUARE  = 'square';
        const API_TRIPLET = 'triplet';

        const ROUTES =
        {
            [API_SQUARE]:  '/api/quizzes/square',
            [API_TRIPLET]: '/api/quizzes/triplet'
        }

        $(function()
        {
            const $navigation = $('#navigation');
            const $errors = $('#errors');
            const $table = $('#api-response');
            const $tbody = $table.find('tbody');

            $('.menu .item').tab({ 'onVisible': function()
            {
                    hideErrorsAndTable(true);
            }});

            $('form').submit(function(event)
            {
                event.preventDefault();

                $navigation.dimmer({ closable: false }).dimmer('show');

                let $form = $(this);

                let name = $form.attr('name');

                hideErrorsAndTable();

                setTimeout(function() {
                    $.ajax({
                        url: ROUTES[name],
                        type: 'POST',

                        data: $form.serialize(),

                        success: function(response)
                        {
                            showTable(response.data);
                        },

                        error: function(error)
                        {
                            showErrors(error.responseJSON)
                        },

                        complete: function()
                        {
                            $navigation.dimmer('hide');
                        }
                    });
                }, 1000);

                return false;
            });

            function hideErrorsAndTable(skipAnimation)
            {
                hideErrors(skipAnimation);
                hideTable(skipAnimation);
            }

            function hideTable(skipAnimation)
            {
                if ($table.is(':visible'))
                {
                         if (skipAnimation) { $table.hide(); }
                    else                    { $table.fadeOut('slow'); }
                }
            }

            function showTable(data)
            {
                $tbody.html('');

                $.each(data, function(key, value) {
                    let $tr = $('<tr>');
                    let $icon = $('<i>', { class: 'key icon' });
                    let $tdKey = $('<td>', { class: 'collapsing' }).text(key).prepend($icon);
                    let $tdValue = $('<td>').text(value);

                    $tr.append($tdKey).append($tdValue);

                    $tbody.append($tr);
                });

                $table.fadeIn('slow');
            }

            function hideErrors(skipAnimation)
            {
                if ($errors.is(':visible'))
                {
                    let settings;

                    if (skipAnimation)
                    {
                        settings = { 'duration': '0s' }
                    }

                    $errors.transition('fly right', settings);
                }
            }

            function showErrors(errors)
            {
                $errors.find('p').remove();

                if (errors)
                {
                    $.each(errors, function(property, value)
                    {
                        $.each(value, function(key, text) {
                            $errors.append($('<p>').text(text));
                        })
                    });
                }
                else
                {
                    $errors.append($('<p>').text('Unexpected Error.'));
                }

                $errors.transition('fly left');
            }
        });
    </script>
@endsection

@section('styles')
    <style>
        #errors,
        #api-response
        {
            margin-top: 0;
        }
    </style>
@endsection
