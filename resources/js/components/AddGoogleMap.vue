<template>
    <div>

        <gmap-map
            :zoom="14"
            :center="center"
            style="width:100%;  height: 200px;"
        >
            <!--<gmap-marker
                :key="index"
                v-for="(m, index) in locationMarkers"
                :position="m.position"
                @click="center = m.position"
            ></gmap-marker>-->
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
                lat: -25.2949068,
                lng: -57.6087548
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
