<?php


namespace App\Services;


use FarhanWazir\GoogleMaps\GMaps;
use GeneaLabs\LaravelMaps\Facades\Map;
use GeneaLabs\LaravelMaps\Map as MyMap;
use Illuminate\Support\Facades\File;
use function Sodium\add;

class MapsServiceSource
{

    /**
     * @var GMaps
     */
    private $maps;

    public function __construct(MyMap $maps)
    {
        $this->maps = $maps;
    }

    /**
     * @param $map  , $attrib;
     *
     * @param  null  $attrib
     *
     * @return Map;
     * *@see Gera Estrutura de  Mapa para retorno na view;
     */
    public function call($map, $attrib = null)
    {

        call_user_func([$this, $map], isset($attrib) ? $attrib : null);

        $map =  Map::create_map();
        //dd($map);
        return $map;

    }

    public function getGeolocation()
    {
        $config['center'] = 'auto';
        $config['onboundschanged'] = 'centreGot = false;
                                      if (!centreGot) {
	                                    var mapCentre = map.getCenter();
	                                    marker_0.setOptions({
		                                    position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng()) 
	                                    });
                                      };';
        Map::initialize($config);

        // set up the marker ready for positioning
        // once we know the users location
        $marker = [];
        Map::add_marker($marker);

    }

    public function markers_single($center)
    {

        $config = [];
        $config['directions'] = 'auto';
        //$config['directionsStart'] = 'Via N2, 40 São Paulo';
        $config['directionsStart'] = 'Via N1, 40 Brasília';
        //$config['directionsStart'] = 'Via N2, 40 São Paulo';
        $config['directionsEnd'] = 'rua potiguaras, 83, Campo Grande MS';
        $config['center'] = implode(',', $center);
        $config['zoom'] = '16';
        $config['styles'] =
            [
                [
                    "name"       => "Localização",
                    "definition" => [
                        [
                            "featureType" => "poi",
                            "elementType" => "labels",
                            "stylers"     => [
                                ["visibility" => "off"]
                            ]
                        ]
                    ]
                ]
            ];

        $config['stylesAsMapTypes'] = false;
        $config['stylesAsMapTypesDefault'] = "Localização";
        Map::initialize($config);

        $marker = [];
        $marker['icon'] = 'http://maps.google.com/mapfiles/kml/shapes/realestate.png';
        $marker['position'] = implode(',', $center);
        Map::add_marker($marker);
    }

    public function markers_multiple()
    {
        $config = [];
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        $config['draggableCursor'] = 'default';
        Map::initialize($config);

        $marker = [];
        $marker['position'] = '37.429, -122.1519';
        $marker['infowindow_content'] = '1 - Hello World!';
        $marker['icon'] = 'http://chart.apis.google.com/chart?chst=d_map_xpin_shadowchld=pin_sleft';
        Map::add_marker($marker);

        $marker = [];
        $marker['position'] = '37.409, -122.1319';
        $marker['draggable'] = true;
        $marker['animation'] = 'DROP';
        Map::add_marker($marker);

        $marker = [];
        $marker['position'] = '37.449, -122.1419';
        $marker['onclick'] = 'alert("You just clicked me!!")';
        Map::add_marker($marker);
    }

    public function polyline()
    {
        $config = [];
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        Map::initialize($config);

        $polyline = [];
        $polyline['points'] = [
            '37.429, -122.1319',
            '37.429, -122.1419',
            '37.4419, -122.1219'
        ];
        Map::add_polyline($polyline);
    }

    public function polygon()
    {
        $config = [];
        $config['center'] = '37.4419, -122.1419';
        $config['zoom'] = 'auto';
        Map::initialize($config);

        $polygon = [];
        $polygon['points'] = [
            '37.425, -122.1321',
            '37.4422, -122.1622',
            '37.4412, -122.1322',
            '37.425, -122.1021'
        ];
        $polygon['strokeColor'] = '#000099';
        $polygon['fillColor'] = '#000099';
        Map::add_polygon($polygon);
    }

    public function drawing()
    {
        $config = [];
        $config['drawing'] = true;
        $config['drawingDefaultMode'] = 'circle';
        $config['drawingModes'] = ['circle', 'rectangle', 'polygon'];
        Map::initialize($config);
    }

    public function directions($addrees)
    {

        $config = [];
        $config['zoom'] = 'auto';
        $config['directions'] = true;
        $config['directionsStart'] = $addrees['origem'][0];
        $config['directionsEnd'] = $addrees['destino'][0];
        $config['directionsDivID'] = 'directionsDiv';
        Map::initialize($config);
    }

    public function streetview()
    {
        $config = [];
        $config['center'] = '37.4419, -122.1419';
        $config['map_type'] = 'STREET';
        $config['streetViewPovHeading'] = 90;
        Map::initialize($config);
    }

    public function style()
    {
        return [

        ];
    }

    public function getLatLng($center = null)
    {


        $json = File::get(config_path().'/jsonMap/styleMapDefault.json');

        $style = json_decode($json, true);

        $var = 'var lat = event.latLng.lat();
                var lng = event.latLng.lng();
                $("#lat").val(lat) 
                $("#lng").val(lng)';

        $config['styles'] =
            [
                ["name" => "Limpo", "definition" => $style],
                [
                    "name" => "Mostrar Detalhes", "definition" => [
                    ["featureType" => "all", "stylers" => [["saturation" => "-30"]]],
                    ["featureType" => "poi.park", "stylers" => [["saturation" => "10"], ["hue" => "#990000"]]]
                ]
                ],
                [
                    "name" => "Limpar Mapa", "definition" => [
                    ["featureType" => "poi", "elementType" => "labels", "stylers" => [["visibility" => "off"]]]
                ]
                ]
            ];
        $config['stylesAsMapTypes'] = true;
        $config['stylesAsMapTypesDefault'] = "Limpar Mapa";


        if ($center) {
            $config['center'] = implode(",", $center);
        }
        $config['onboundschanged'] = 'centreGot = false;
                                      if (!centreGot) {
	                                    var mapCentre = map.getCenter();
	                                    marker_0.setOptions({
		                                    position: new google.maps.LatLng(mapCentre.lat(), mapCentre.lng())
	                                    });
	                                    $("#lat").val(mapCentre.lat());
		                                $("#lng").val(mapCentre.lng());
                                      };';
        $config['zoom'] = '14';
        $config['mapTypeId'] = 'google.maps.MapTypeId.TERRAIN';

        Map::initialize($config);

        $marker = [];
        $marker['position'] = 'map.getCenter().lat(), map.getCenter().lng()';
        $marker['draggable'] = true;
        $marker['ondragend'] = $var;
        $marker['icon'] = 'https://icons.iconarchive.com/icons/icons-land/vista-map-markers/48/Map-Marker-Push-Pin-1-Chartreuse-icon.png';
        Map::add_marker($marker);
    }

    public function clustering($center = null)
    {
        $config = [];
        $config['center'] = implode("", $center);
        $config['zoom'] = '13';
        $config['cluster'] = true;
        $config['clusterStyles'] = [
            [
                "url"    => "https://raw.githubusercontent.com/googlemaps/js-marker-clusterer/gh-pages/images/m1.png",
                "width"  => "53",
                "height" => "53"
            ]
        ];
        Map::initialize($config);

        if ($center) {
            $marker = [];
            $marker['position'] = implode('', $center);
            Map::add_marker($marker);
        }

        $marker = [];
        $marker['position'] = '37.409, -122.1419';
        Map::add_marker($marker);

        $marker = [];
        $marker['position'] = '37.409, -122.1219';
        Map::add_marker($marker);

        $marker = [];
        $marker['position'] = '37.409, -122.1519';
        Map::add_marker($marker);

    }

    public function kml_layer()
    {
        $config = [];
        $config['zoom'] = 'auto';
        $config['kmlLayerURL'] = 'https://www.google.com/maps/d/kml?mid=zQsfa8t0PJbc.kXZmQVidOFfE';
        Map::initialize($config);
    }

}
