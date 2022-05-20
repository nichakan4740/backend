package sit.int221.oasip.Service;

import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Sort;
import org.springframework.stereotype.Service;
import sit.int221.oasip.DTO.EventDTO;
import sit.int221.oasip.Entity.Event;
import sit.int221.oasip.Repository.EventRepository;
import sit.int221.oasip.Utils.ListMapper;

import java.util.List;

@Service
public class SortService {

    @Autowired
    private EventRepository repository;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private ListMapper listMapper;

    public List<EventDTO> getSort(String sortBy) {
        List<Event> event = repository.findAll(Sort.by(sortBy));
        return listMapper.mapList(event, EventDTO.class, modelMapper);
    }

}
