package sit.int221.oasip.Controller;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.validation.annotation.Validated;
import org.springframework.web.bind.annotation.*;
import sit.int221.oasip.DTO.EventsDTO;
import sit.int221.oasip.Entity.Events;
import sit.int221.oasip.Service.EventsService;

import java.util.List;

@CrossOrigin(origins = "*")
@RestController
@RequestMapping("/api/events")
class EventsController {
    @Autowired
    private EventsService service;

    //Get all Event
    @GetMapping("")
    public List<EventsDTO> getAllEvent(@RequestParam(defaultValue = "eventStartTime") String sortBy){
        return service.getAllEvent(sortBy);
    }

    //Get Event with id
    @GetMapping("/{id}")
    public EventsDTO getCustomerById(@PathVariable Integer id) {
        return service.getSimpleCustomerById(id);
    }

    //Add new Event
    @PostMapping("")
    public Events create(@Validated @RequestBody Events newEvents){
        return service.save(newEvents);
    }

    //Delete an event with id = ?
    @DeleteMapping("/{id}")
    public void delete(@PathVariable Integer id) {
        service.deleteById(id);
    }

    //Update an event with id = ?
    @PutMapping("/{id}")
    public Events update(@RequestBody Events updateEvents, @PathVariable Integer id) {
        return service.updateId(updateEvents, id);
    }

}
