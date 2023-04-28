import React, { useEffect, useState } from 'react'
import Select from 'react-select'

export default function Suku({ onchangeHandle, valueHandle }) {

  const [data, setData] = useState([])

   useEffect(() => {
      loadSuku();
   }, [])

   const loadSuku = async () => {
    try {
      let { data } = await axios.get(route('master.suku.json'));
      setData(data);
    } catch (error) {
      console.log(error);
    }
   }
   

  return (
    <Select options={data} onChange={onchangeHandle} value={data.filter(obj => (obj.kode_suku == valueHandle))} />
  )
}
