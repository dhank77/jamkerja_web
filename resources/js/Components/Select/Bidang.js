import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Bidang({ onchangeHandle, valueHandle, skpd = 0 }) {

  const [data, setData] = useState([])

  useEffect(() => {
    loadData();
  }, [skpd])

  const loadData = async () => {
    try {
      let { data } = await axios.get(route('master.bidang.json', skpd));
      setData(data);
    } catch (error) {
      console.log(error);
    }
  }


  return (
    <Select options={data} onChange={onchangeHandle} value={data.filter(obj => (obj.kode_bidang == valueHandle))} />
  )
}
