<div class="container">
    <div class="top-container">
        <h2>GET IN TOUCH WITH US</h2>
        <hr>
    </div>
    <form action="/contact" method="post">
        <div class="messages"></div>
        {{ csrf_field() }}
        <fieldset class="fieldset">
            <div class="float-left col-md-6 col-sm-12 col-xs-12">
                <div class="field">
                    <label for="name"><span>{{ __('Name') }} *</span></label>
                    <div>
                        <input name="name" title="{{ __('Name') }}" type="text" required />
                    </div>
                </div>
                <div class="field">
                    <label for="email"><span>{{ __('Email') }} *</span></label>
                    <div>
                        <input name="email" title="{{ __('Email') }}" type="email" required />
                    </div>
                </div>
                <div class="field">
                    <label for="telephone"><span>{{ __('Phone Number') }}</span></label>
                    <div>
                        <input name="phone" id="phone" title="{{ __('Phone Number') }}" value="" class="input-text" type="text">
                    </div>
                </div>
            </div>
            <div class="float-left col-md-6 col-sm-12 col-xs-12">
                <div class="field">
                    <label for="message"><span>{{ __('Your message here') }} *</span></label>
                    <div>
                        <textarea name="message" id="comment" title="{{ __('Your message here') }}" class="input-text" cols="5" rows="4" required ></textarea>
                    </div>
                </div>
                <div class="actions-toolbar">
                    <div>
                        <input type="hidden" name="hideit" id="hideit" value="">
                        <button type="submit" title="{{ __('Submit') }}" class="action submit">
                            <span>{{ __('Submit') }}</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </fieldset>
    </form>
</div>