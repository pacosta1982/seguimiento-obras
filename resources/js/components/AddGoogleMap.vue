<template>
    <div>

        <gmap-map
            :zoom="14"
            :center="center"
            map-type-id="hybrid"
            style="width:100%;  height: 300px;"
        >
            <gmap-marker
                :position="center"
            ></gmap-marker>
        </gmap-map>
    </div>
</template>

<script>
export default {
    name: "AddGoogleMap",
    props: {
        latitude: {
            type: Number
        },
        longitude: {
            type: Number
        }
    },
    data(props) {
        return {
            center: {
                lat: props.latitude,
                lng: props.longitude
            },
            locationMarkers: [],
            locPlaces: [],
            existingPlace: null
        };
    },

    mounted() {
        this.locateGeoLocation(this.latitude, this.longitude);
    },

    methods: {
        initMarker(loc) {
            this.existingPlace = loc;
        },
        addLocationMarker() {
            if (this.existingPlace) {
                const marker = {
                    lat: this.existingPlace.geometry.location.lat(),
                    lng: this.existingPlace.geometry.location.lng()
                };
                this.locationMarkers.push({ position: marker });
                this.locPlaces.push(this.existingPlace);
                this.center = marker;
                this.existingPlace = null;
            }
        },
        locateGeoLocation: function(latitude, longitude) {
            navigator.geolocation.getCurrentPosition(res => {
                this.center = {
                    lat: latitude,
                    lng: longitude
                };
            });
            console.log(latitude, longitude);
        }
    }
};
</script>
