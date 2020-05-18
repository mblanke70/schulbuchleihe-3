@extends('layouts.sport')

@section('title', 'Sportkurswahlen')

@section('heading')
    <h3 class="mt-3">Sportwahl für die Jahrgangsstufen 12 und 13: <strong>{{ $user->name }}</strong></h3>
@endsection

@section('content')

    @if ($errors->any())
    <div class="alert alert-danger">
        {{ $errors->first() }}
    </div>
    @endif

    <form class="mt-3" action="{{ url('user/sportwahlen/wahlbogen') }}" method="POST" role="form">

    {{ csrf_field() }}

    <div class="container mb-3">

        <div class="row">
            <div class="col-1">&nbsp;</div>
            <div class="col">
                <strong>Den Bewegungsfeldern der Gruppe A</strong> liegen primär eine Bewegungsidee zugrunde, wobei das individuelle sportliche Handeln im Vordergrund steht
            </div>
            <div class="col">
                <strong>Den Bewegungsfeldern der Gruppe B</strong> liegen Spielideen zugrunde, wobei partner- und gemeinschaftsbezogenes sportliches Handeln den Schwerpunkt bilden
            </div>
        </div>

        @for ($sem = 1; $sem <= 4; $sem++)
            
            <div style="background-color: #eee;" class="row mt-2">

                <div class="col-1">
                    <span class="font-weight-bold">
                    {{ $semester[$sem]["name"] }}
                    </span>
                </div>

                @for ($bf = 0; $bf <= 1; $bf++)

                    @for ($pos = 1; $pos <= 4; $pos++)

                        @if ( array_key_exists($pos, $semester[$sem][$bf]) )

                <div class="form-group col">
                    <div class="form-check">
                        <input class="form-check-input" name="wahl[{{ $sem-1 }}]" type="radio" id="{{ 'k'.$sem.$bf.$pos }}" value="{{ $semester[$sem][$bf][$pos]->id }}" 

                    @if( is_array(old('wahl')) && 
                        in_array( $semester[$sem][$bf][$pos]->id , old('wahl'))) 
                        checked 
                    @endif
                        ><br />
                        <label class="form-check-label col-form-label" for="{{ 'k'.$sem.$bf.$pos}}">
                            <strong>
                                <a target="_blank" href="{{ url('pdf/'. $semester[$sem][$bf][$pos]->pdf) }}">{{ $semester[$sem][$bf][$pos]->titel }} </a>
                            </strong>

                            @if ( $semester[$sem][$bf][$pos]->untertitel != null )

                                {{ $semester[$sem][$bf][$pos]->untertitel }}

                            @endif

                        </label>
                    </div>
                </div>
                        @else

                <div class="form-group col">&nbsp;</div>

                        @endif

                    @endfor

                @endfor

            </div>

        @endfor


        <div style="background-color: #eee;" class="row mt-2">

            <div class="col-1">&nbsp;</div>
       
    @for($i=0; $i<2; $i++)

        <div class="form-group col">
            <label for="sub{{$i}}"><strong>Ersatzwahl {{chr(65+$i)}}</strong></label>
            <select id="sub{{$i}}" name="ersatzwahl[{{$i}}]" class="form-control">
                <option value="">Bitte wählen...</option>

                @foreach( $ersatz[$i] as $key => $value )
                <option value="{{ $key }}" 
               
                    @if( is_array(old('ersatzwahl')) && in_array( $key , old('ersatzwahl'))) 
                        selected 
                    @endif
                    
                >{{ $value }}</option>

                @endforeach
               
            </select>
        </div>

    @endfor
            
        </div>

        <div class="row mt-2">
            <button type="submit" class="btn btn-primary">Speichern</button>
        </div>
       
    </div>       
    
    </form>

    <h4>Anmerkungen:</h4>
    <ul>
        <li><strong>Zeiten</strong>: Der Sportunterricht findet für den Jahrgang 12 Dienstag in der 5./6. Stunde und für den Jahrgang 13  Freitag in der 5./6. Stunde statt. Änderungen aus organisatorischen Gründen sind möglich!</li>
        <li><strong>*Orientierungslauf</strong> findet in mehreren Blöcken dienstags (12/1) bzw. freitags (13/1) ab ca. 11.30 Uhr Semester begleitend statt.</li>
        <li><strong>**Alpiner Skilauf</strong>: Die Praxisphase findet im Januar 2021 direkt nach den Weihnachtsferien statt. Die Vor- und Nachbereitung ist Semester begleitend. Kosten ca. 380,- €; nur für Fortgeschrittene; Leitung und weitere Informationen: H. Blanke, H. Laermann, H. Maaß</li>
        <li><strong>Tennis</strong>: Kostenanteil ca. 25,- € pro Semester; eigener Schläger und Tennis-Hallenschuhe (ohne Profil) oder saubere Hallenschuhe mit glatt geschliffenen Sohlen</li>
        <li><strong>Fitness/Soccer</strong>: evtl. Kosten ca. 3,- € pro Stunde</li>
        <li><strong>Rudern</strong>: Kostenanteil ca. 25,- €; Voraussetzung für die Teilnahme ist der Jugendschwimmschein Bronze</li>
        <li><strong>Badminton</strong>: Eigener Schläger und eigene Bälle</li>
        <li><strong>Wahlmodus</strong> (Ergänzungsfach): Zwei verschiedene Sportarten aus BF-A und zwei verschiedene aus BF-B und je BF mindestens eine Ersatzwahl</li>
    </ul>

    <h4>Belegungsverpflichtung (Ergänzungsfach):</h4>
    <p>
        Jeder Schüler muss vier zweistündige Praxiskurse, davon zwei verschiedene Themen aus dem BF-A und zwei verschiedene Themen aus dem BF-B belegen. Jede Sportart darf nur ein Mal gewählt werden.  Es können maximal drei Kurse in den Block I der Gesamtqualifikation eingebracht werden. Wird mehr als ein Kurs eingebracht, muss mindestens ein Kurs aus dem BF-A sein.
    </p>
    <h4>Vorgaben für Sport als 5. Prüfungsfach:</h4>
    <p>
        Vier Semesterkurse Sportpraxis (In Absprache mit dem P5-Kursleiter müssen mindestens 2 sportpraktische Inhalte aus BF-A sowie 3 sportpraktische Inhalte aus BF-B belegt werden, wobei ein Zielschuss- und ein Rückschlagspiel enthalten sein müssen) und vier zweistündige Theoriekurse werden im Theorie-Praxis-Verbund  belegt und ergeben jeweils eine Sportnote (1:1). Alle vier Kurse müssen eingebracht werden.
    </p>
    <p>
        Die Abiturprüfung besteht aus zwei Teilen: a) praktische Prüfung in zwei Sportarten (1x aus BF-A und 1x aus BF-B), die vorher belegt worden sein müssen und b) mündliche Prüfung in Sporttheorie.
    </p>
    <p>
        Vor Eintritt in die Kursstufe muss eine sportärztliche Unbedenklichkeitsbescheinigung vorgelegt werden. Falls bis zum Ende des zweiten Kurshalbjahres Sportunfähigkeit eintritt, ist ein anderes Fach als 5. Prüfungsfach zu belegen.
    </p>
    <p>
        Folgende Sportarten können in der sportpraktischen Abiturprüfung grundsätzlich nicht geprüft werden: Skifahren, Ultimate Frisbee. Tanz ist nur als ein Prüfungsteil in der Gymnastik möglich.
    </p>
    <p>
        Weitere Informationen sind den Anschlagbrettern zu entnehmen oder bei euren Sportlehrern oder dem zuständigen Koordinator zu erfragen.
    </p>

@endsection

@section('js')

    <script>
        var dependents = new Array();
  
        dependents["k101"] = new Array("k202");
        dependents["k102"] = new Array("k201");
        dependents["k103"] = new Array();
        dependents["k104"] = new Array();
        dependents["k111"] = new Array();
        dependents["k112"] = new Array("k214","k312");
        dependents["k113"] = new Array("k212");
        dependents["k114"] = new Array("k411");

        dependents["k201"] = new Array("k102");
        dependents["k202"] = new Array("k101");
        dependents["k203"] = new Array("k402");
        dependents["k204"] = new Array();
        dependents["k211"] = new Array("k413");
        dependents["k212"] = new Array("k113");
        dependents["k213"] = new Array("k311","k412");
        dependents["k214"] = new Array("k112","k312");
          
        dependents["k301"] = new Array();
        dependents["k302"] = new Array();
        dependents["k303"] = new Array();
        dependents["k304"] = new Array();
        dependents["k311"] = new Array("k213","412");
        dependents["k312"] = new Array("k112","k214");
        dependents["k313"] = new Array();
        dependents["k314"] = new Array();
          
        dependents["k401"] = new Array();
        dependents["k402"] = new Array("k203");
        dependents["k403"] = new Array();
        dependents["k404"] = new Array();
        dependents["k411"] = new Array("k114");
        dependents["k412"] = new Array("k311","k213");
        dependents["k413"] = new Array("k211");
        dependents["k414"] = new Array();  


        var substitutes = new Array();
  
        substitutes["k101"] = new Array("a7");
        substitutes["k102"] = new Array("a3");
        substitutes["k103"] = new Array("a1");
        substitutes["k104"] = new Array();
        substitutes["k111"] = new Array("b7");
        substitutes["k112"] = new Array("b2");
        substitutes["k113"] = new Array("b0");
        substitutes["k114"] = new Array("b9");

        substitutes["k201"] = new Array("a3");
        substitutes["k202"] = new Array("a7");
        substitutes["k203"] = new Array("a2");
        substitutes["k204"] = new Array();
        substitutes["k211"] = new Array("b8");
        substitutes["k212"] = new Array("b0");
        substitutes["k213"] = new Array("b1","b4","b5");
        substitutes["k214"] = new Array("b2");

        substitutes["k301"] = new Array("a4");
        substitutes["k302"] = new Array("a5");
        substitutes["k303"] = new Array("a6");
        substitutes["k304"] = new Array();
        substitutes["k311"] = new Array("b1","b4","b5");
        substitutes["k312"] = new Array("b2");
        substitutes["k313"] = new Array("b6");
        substitutes["k314"] = new Array();

        substitutes["k401"] = new Array("a0");
        substitutes["k402"] = new Array("a2");
        substitutes["k403"] = new Array("a8");
        substitutes["k404"] = new Array();
        substitutes["k411"] = new Array("b9");
        substitutes["k412"] = new Array("b4","b5","b1");
        substitutes["k413"] = new Array("b8");
        substitutes["k414"] = new Array();

        $(document).ready(function () 
        {
            updateForm();

            // Event-Listener für Radio-Buttons
            $('input[type=radio]').change(function () {
                updateForm();
            })
        })

        function updateForm()
        {
            // Radio-Buttons
            $("input[type=radio]:disabled").removeAttr('disabled');
            
            $("input[type=radio]:checked").each( function() {
                $.each(dependents[$(this).attr('id')], function(index, value) {
                    $("#" + value).attr('disabled', 'disabled');
                })
            })

            // Select-Listen
            $("option:disabled").removeAttr('disabled');

            $("input[type=radio]:checked").each(function() {
                $.each(substitutes[$(this).attr('id')], function(index, value) {
                    $("option[value=" + value + "]").attr('disabled', 'disabled');    

                    if(value==$("#subA option:selected").val()) {
                        $("#subA option:first").prop('selected', 'true');
                    }
                    
                    if(value==$("#subB option:selected").val())
                        $("#subB option:first").prop('selected', 'true');
                })
            })
        }
    
    </script>

@endsection