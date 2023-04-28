import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Seksi({ onchangeHandle, valueHandle, bidang = 0 }) {

  const [data, setData] = useState([])

  useEffect(() => {
    loadData();
  }, [bidang])

  const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.seksi.json', bidang));
      setData(data);
    } catch (error) {
      console.log(error);
    }
  }


  return (
    <Select options={data} onChange={onchangeHandle} value={data.filter(obj => (obj.kode_seksi == valueHandle))} />
  )
}
