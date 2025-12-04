import ToastComponent from "../../vendor/usernotnull/tall-toasts/resources/js/tall-toasts";
import "./bootstrap";
import collapse from "@alpinejs/collapse";
import ApexCharts from "apexcharts";
import Swal from "sweetalert2";

// Global data and functions for dashboard
function dashboardLogic() {
    return {
        isSidebarOpen: false,
    };
}

// Reusable Alpine component for ApexCharts
function apexChart(chartData) {
    return {
        chart: null,
        init() {
            console.log(chartData);
            // SAFEGUARD: Cek apakah chartData valid, jika tidak beri nilai default
            const safeData = chartData || {};
            const values = safeData.values || []; // Default ke array kosong jika undefined
            const labels = safeData.labels || [];
            const seriesName = safeData.seriesName || "Aktivitas";

            // Jangan render chart jika data benar-benar kosong (Opsional, agar UI lebih rapi)
            if (values.length === 0) {
                console.warn(
                    "ApexChart: No data provided provided for values."
                );
                // Anda bisa me-return atau menampilkan pesan "Belum ada data" di UI
                return;
            }

            const options = {
                series: [
                    {
                        name: seriesName,
                        data: values, // Gunakan variabel yang sudah diamankan
                    },
                ],
                chart: {
                    type: "bar",
                    height: 320,
                    fontFamily: "inherit",
                    toolbar: { show: false },
                },
                plotOptions: {
                    bar: {
                        borderRadius: 4,
                        horizontal: false,
                        columnWidth: "50%", // Agar bar tidak terlalu gemuk jika data sedikit
                    },
                },
                xaxis: {
                    categories: labels, // Gunakan variabel yang sudah diamankan
                },
                colors: ["#065F46"],
                dataLabels: {
                    enabled: false,
                },
                // Tambahkan tooltip agar lebih informatif saat kosong
                noData: {
                    text: "Belum ada aktivitas belajar.",
                    align: "center",
                    verticalAlign: "middle",
                    style: {
                        color: "#64748B",
                        fontSize: "14px",
                        fontFamily: "inherit",
                    },
                },
            };

            this.chart = new ApexCharts(this.$el, options);
            this.chart.render();
        },
    };
}

window.Swal = Swal;
window.dashboardLogic = dashboardLogic;
window.apexChart = apexChart;

// Inisialisasi Alpine
Alpine.plugin(collapse);
Alpine.plugin(ToastComponent);

// Listener global untuk modal (buka/tutup)
document.addEventListener("alpine:init", () => {
    Alpine.store("modal", {
        active: false,
        component: null,
        params: {},

        open(component, params = {}) {
            this.component = component;
            this.params = params;
            this.active = true;
            this.$dispatch("open-modal", { id: "default-modal" }); // Trigger modal Blade
        },

        close() {
            this.active = false;
            this.component = null;
            this.params = {};
            this.$dispatch("close-modal");
        },
    });
});

// Fungsi global Alpine untuk konfirmasi delete via SweetAlert2
window.confirmDelete = function (id) {
    window.Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Anda tidak akan bisa mengembalikan ini!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#065F46", // primary color
        cancelButtonColor: "#d33",
        confirmButtonText: "Ya, hapus!",
        cancelButtonText: "Batal",
    }).then((result) => {
        if (result.isConfirmed) {
            Livewire.dispatch("delete-confirmed", { id: id });
        }
    });
};
