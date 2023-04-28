import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function StatusPegawai({ onchangeHandle, valueHandle }) {

  const [data, setData] = useState([])

   useEffect(() => {
      loadData();
   }, [])

   const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.status_pegawai.json'));
      setData(data);
    } catch (error) {
      console.log(error);
    }
   }
   

  return (
    <Select options={data} onChange={onchangeHandle} value={data.filter(obj => (obj.kode_status == valueHandle))} />
  )
}
