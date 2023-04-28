import React, { useEffect, useState } from 'react'

export default function DateNowIndo() {

    const [tanggal, setTanggal] = useState("")

    useEffect(() => {
        const interval = setInterval(() => {
            var date = new Date(); var tahun = date.getFullYear();
            var bulan = date.getMonth();
            var tanggal = date.getDate();
            var hari = date.getDay(); var jam = date.getHours();
            var menit = date.getMinutes();
            var detik = date.getSeconds();
            switch (hari) {
                case 0: hari = "Minggu"; break;
                case 1: hari = "Senin"; break;
                case 2: hari = "Selasa"; break;
                case 3: hari = "Rabu"; break;
                case 4: hari = "Kamis"; break;
                case 5: hari = "Jum'at"; break;
                case 6: hari = "Sabtu"; break;
            }
            switch (bulan) {
                case 0: bulan = "Januari"; break;
                case 1: bulan = "Februari"; break;
                case 2: bulan = "Maret"; break;
                case 3: bulan = "April"; break;
                case 4: bulan = "Mei"; break;
                case 5: bulan = "Juni"; break;
                case 6: bulan = "Juli"; break;
                case 7: bulan = "Agustus"; break;
                case 8: bulan = "September"; break;
                case 9: bulan = "Oktober"; break;
                case 10: bulan = "November"; break;
                case 11: bulan = "Desember"; break;
            }

            setTanggal(hari + ", Tanggal : " + tanggal + " " + bulan + " " + tahun + " " + " Jam: " + jam + ":" + menit + ":" + detik)

        }, 1000);

        return () => clearInterval(interval);
    }, []);

    return (
        <h4 className='fs-4 text-dark'>{tanggal}</h4>
    )
}
