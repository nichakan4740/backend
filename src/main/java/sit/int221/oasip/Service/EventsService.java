package sit.int221.oasip.Service;

import org.modelmapper.ModelMapper;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Sort;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Service;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.server.ResponseStatusException;
import sit.int221.oasip.DTO.EventsDTO;
import sit.int221.oasip.Entity.Events;
import sit.int221.oasip.Repository.EventsRepository;
import sit.int221.oasip.Utils.ListMapper;

import java.util.List;

@Service
public class EventsService {
    @Autowired
    private EventsRepository repository;

    @Autowired
    private ModelMapper modelMapper;

    @Autowired
    private ListMapper listMapper;


    //Get all Event
    public List<EventsDTO> getAllEvent(String sortBy) {
        List<Events> events = repository.findAll(Sort.by(sortBy).descending());
        return listMapper.mapList(events, EventsDTO.class, modelMapper);
    }

    //Get Event with id
    public EventsDTO getSimpleCustomerById(Integer id) {
        Events events = repository.findById(id)
                .orElseThrow(() -> new ResponseStatusException(
                        HttpStatus.NOT_FOUND, "Event id " + id +
                        "Does Not Exist !!!"
                ));

        return modelMapper.map(events, EventsDTO.class);
    }

    //Add new Event
    public Events save(Events newEvents) {
        Events e = modelMapper.map(newEvents, Events.class);
        return repository.saveAndFlush(e);
    }


    //delete event with id = ?
    public void deleteById(Integer id) {
        repository.findById(id).orElseThrow(()->
                new ResponseStatusException(HttpStatus.NOT_FOUND,
                        id + " does not exist !!!"));
        repository.deleteById(id);
    }

    //update event with id = ?
    public Events updateId(@RequestBody Events updateEvents, @PathVariable Integer id) {
        Events events = repository.findById(id).map(o->mapEvent(o, updateEvents))
                .orElseGet(()->
                {
                    updateEvents.setId(id);
                    return updateEvents;
                });
        return repository.saveAndFlush(events);
    }
    private Events mapEvent(Events existingEvents, Events updateEvents) {
        existingEvents.setEventNotes(updateEvents.getEventNotes());
        existingEvents.setEventStartTime(updateEvents.getEventStartTime());

        return existingEvents;
    }
}
