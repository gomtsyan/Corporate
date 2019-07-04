@if($contacts)
    @if(!$contacts->isEmpty())

            <div class="widget-first widget contact-info">
                <h3>{{ Lang::get('ru.contacts') }}</h3>
                <div class="sidebar-nav">
                    <ul>
                        @foreach($contacts as $contact)
                            <li>
                                <i class="{{ $contact->icon }}" style="color:#979797;font-size:20pxpx"></i> {{ $contact->name }}: {{ $contact->value }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="widget-last widget text-image">
                <h3>Customer Support</h3>
                <div class="text-image" style="text-align:left"><img src="{{ asset(config('settings.theme')) }}/images/callus.gif" alt="Customer Support" /></div>
                <p>Nunc sit amet pretium purus. Pellet netus et malesuada fames ac turpis egestas.entesque habitant morbi tristique senectus </p>
            </div>

    @endif
@endif
