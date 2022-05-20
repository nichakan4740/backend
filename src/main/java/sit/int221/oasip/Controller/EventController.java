package sit.int221.oasip.Controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.domain.Sort;
import org.springframework.http.HttpStatus;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;
import org.springframework.web.server.ResponseStatusException;
import sit.int221.oasip.DTO.EventDTO;
import sit.int221.oasip.Entity.Event;
import sit.int221.oasip.Repository.EventRepository;
import sit.int221.oasip.Service.EventService;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/booking")
class EventController {
    @Autowired
    private EventService service;

    @Autowired
    private EventRepository repository;

    //Get all Event
    @GetMapping("")
    public List<EventDTO> getAllEvent(){
        return service.getAllEvent();
    }

    //Get Event with id
    @GetMapping("/{id}")
    public EventDTO getCustomerById (@PathVariable Integer id) {
        return service.getSimpleCustomerById(id);
    }

    //Add new Event
    @PostMapping("")
    public Event create(@Validated  @RequestBody Event newEvent){
        return service.save(newEvent);
    }

    //Delete an event with id = ?
    @DeleteMapping("/{id}")
    public void delete(@PathVariable Integer id) {
        service.deleteById(id);
    }

    //Update an event with id = ?
    @PutMapping("/{id}")
    public Event update(@RequestBody Event updateEvent, @PathVariable Integer id) {
        return service.updateId(updateEvent , id);
    }

//    @GetMapping("")
//    public List<Event> findAll(String keyword){
//        if (keyword != null) {
//            return repository.findAll(keyword);
//        }
//        return repository.findAll();
//    }


}
