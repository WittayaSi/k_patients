new Vue({
    http: {
        root: '/root',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('#token').getAttribute('value')
        }
    },
    el: '#vueApp',
    data: {
        app_now: ''
    },

    created() {
        this.fetchData()
            // this.lineNotify()
    },

    computed: {
        isActived: function() {
            return this.pagination.current_page;
        },
        pagesNumber: function() {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset;
            if (from < 1) {
                from = 1;
            }
            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page;
            }
            var pagesArray = [];
            while (from <= to) {
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
        },
    },

    filters: {
        getDate(date) {
            const d = new Date(date)
            const m = [
                'มกราคม',
                'กุมภาพันธ์',
                'มีนาคม',
                'เมษายน',
                'พฤษภาคม',
                'มิถุนายน',
                'กรกฎาคม',
                'สิงหาคม',
                'กันยายน',
                'ตุลาคม',
                'พฤศจิกายน',
                'ธันวาคม'
            ]
            const month = m[(d.getMonth())]
            return `${d.getDate() < 10
            ? '0' + d.getDate()
            : d.getDate()} ${month} ${d.getFullYear()+543}`
        }
    },

    methods: {
        fetchData() {
            this.$http.get('/home/getNowAppoint').then((res) => {
                console.log(res.data.rawData)
                console.log(res.data.date_now)
                this.app_now = res.data.rawData
            })
        },
        lineNotify() {
            this.$http.get('/home/lineNotify').then((res) => {
                console.log(res.data.rawData)
                console.log(res.data.date_tomorrow)
                console.log(res.data.app_no)
                console.log(res.data.message)
            })
        }
    }
})